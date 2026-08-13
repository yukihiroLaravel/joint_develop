@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // SVGドーナツを表示する領域を取得する
            const chart = document.getElementById('reaction-donut-chart');

            // Bladeから渡されたリアクション集計JSONを取得する
            const dataElement = document.getElementById('reaction-donut-data');

            /*
             * ドーナツの表示領域または集計データがない画面では、
             * 何もせず安全に処理を終える。
             */
            if (!chart || !dataElement) {
                return;
            }

            // JSON文字列をJavaScriptで扱える配列へ変換する
            const reactions = JSON.parse(dataElement.textContent);

            /*
             * 合計件数を計算する。
             * 画面に渡された件数の合計を使うことで、SVGの円弧の割合を正確に求める。
             */
            const total = reactions.reduce(function (sum, reaction) {
                return sum + reaction.count;
            }, 0);

            /*
             * 0件の区分は円弧アニメーションの対象から除外する。
             * 件数が多い順に並べ、同数の場合はBlade側の既存順を維持する。
             */
            const visibleReactions = reactions
                .filter(function (reaction) {
                    return reaction.count > 0;
                })
                .sort(function (a, b) {
                    return b.count - a.count;
                });

            /*
             * 右カラム内で、従来の外径220px相当に見える大きさで
             * ドーナツを表示するための基準値。
             */
            const svgNamespace = 'http://www.w3.org/2000/svg';
            const centerX = 200;
            const centerY = 170;
            const radius = 88;
            const strokeWidth = 56;
            const circumference = 2 * Math.PI * radius;

            /*
             * OSの「動きを減らす」設定と、スマホ幅かどうかを取得する。
             * スマホではSVG内のラベルを非表示にし、既存凡例を使う。
             */
            const reduceMotion = window.matchMedia(
                '(prefers-reduced-motion: reduce)'
            ).matches;
            const isMobile = window.matchMedia(
                '(max-width: 767.98px)'
            ).matches;

            /*
             * SVG要素を作り、渡された属性を設定する共通関数。
             * circle、path、textなどを同じ書き方で生成できるようにする。
             */
            function createSvgElement(name, attributes) {
                const element = document.createElementNS(svgNamespace, name);

                Object.keys(attributes || {}).forEach(function (key) {
                    element.setAttribute(key, attributes[key]);
                });

                return element;
            }

            /*
             * アニメーションの完了を待つための関数。
             * 指定したミリ秒後に、次の処理へ進める。
             */
            function wait(milliseconds) {
                return new Promise(function (resolve) {
                    window.setTimeout(resolve, milliseconds);
                });
            }

            /*
             * ドーナツの中心から、指定角度・指定距離の座標を求める。
             * 円弧の中央からガイド線を伸ばす位置の計算に使う。
             */
            function polarPoint(angle, distance) {
                const radians = (angle - 90) * Math.PI / 180;

                return {
                    x: centerX + Math.cos(radians) * distance,
                    y: centerY + Math.sin(radians) * distance,
                };
            }

            /*
             * SVG全体の表示範囲を作る。
             * ドーナツ本体は外径220pxを維持し、
             * 右側・左側のガイド線とラベルを置ける余白を確保する。
             */
            const svg = createSvgElement('svg', {
                viewBox: '0 0 400 340',
                'aria-hidden': 'true',
            });

            /*
             * リアクションが0件でも表示する、薄い灰色の背景リング。
             * 実際の色付き円弧は、この上に後から重ねる。
             */
            const baseRing = createSvgElement('circle', {
                cx: centerX,
                cy: centerY,
                r: radius,
                fill: 'none',
                stroke: '#e9ecef',
                'stroke-width': strokeWidth,
            });

            /*
             * ドーナツの中央に重ねる背景円。
             * 右カラムで直径130px相当に見える大きさを維持する。
             */
            const centerCircle = createSvgElement('circle', {
                cx: centerX,
                cy: centerY,
                r: 68,
                class: 'reaction-donut-center',
            });

            /*
             * 中央に表示する「計」「合計件数」「件」。
             * 円弧とラベルの表示が完了した後に、順番に表示する。
             */
            const centerTexts = [
                {
                    text: '計',
                    y: centerY - 18,
                    size: 13,
                    color: '#6c757d',
                },
                {
                    text: total,
                    y: centerY + 8,
                    size: 24,
                    color: '#343a40',
                    weight: 700,
                },
                {
                    text: '件',
                    y: centerY + 30,
                    size: 14,
                    color: '#6c757d',
                },
            ].map(function (item) {
                const text = createSvgElement('text', {
                    x: centerX,
                    y: item.y,
                    'text-anchor': 'middle',
                    fill: item.color,
                    'font-size': item.size,
                    'font-weight': item.weight || 400,
                });

                text.textContent = item.text;
                text.style.opacity = '0';

                return text;
            });

            // SVG内で最初に表示する土台の要素を追加する
            svg.appendChild(baseRing);
            svg.appendChild(centerCircle);

            /*
             * 件数があるリアクションごとに、色付きの円弧を作る。
             * この時点では円弧を見えない状態で準備し、
             * 後の処理で件数の多い順に伸ばしていく。
             */
            let accumulatedPercentage = 0;

            const segments = visibleReactions.map(function (reaction) {
                // この区分より前に描かれる円弧の合計割合
                const startPercentage = accumulatedPercentage;

                // 丸め前の正確な割合。円弧の長さ計算に使う
                const exactPercentage = (reaction.count / total) * 100;

                // 次の区分の開始位置を求めるため、割合を積み上げる
                accumulatedPercentage += exactPercentage;

                /*
                 * 円弧を描くcircle要素。
                 * -90度回転させ、ドーナツの開始位置を12時方向にする。
                 */
                const circle = createSvgElement('circle', {
                    cx: centerX,
                    cy: centerY,
                    r: radius,
                    fill: 'none',
                    stroke: reaction.color,
                    'stroke-width': strokeWidth,
                    'stroke-linecap': 'butt',
                    transform: 'rotate(-90 ' + centerX + ' ' + centerY + ')',
                });

                // 円周のうち、この区分が占める長さ
                const arcLength = circumference * (exactPercentage / 100);

                /*
                 * 最初は円弧の長さを0にして見えない状態にする。
                 * strokeDashoffsetで、前の区分の終端から描き始める位置を指定する。
                 */
                circle.style.strokeDasharray = '0 ' + circumference;
                circle.style.strokeDashoffset =
                    -circumference * (startPercentage / 100);

                svg.appendChild(circle);

                return {
                    reaction: reaction,
                    circle: circle,
                    arcLength: arcLength,
                    /*
                     * 円弧の中央角度。
                     * 後でガイド線を出す開始位置として使う。
                     */
                    middleAngle:
                        startPercentage * 3.6 + exactPercentage * 1.8,
                };
            });

            /*
             * 同じ側に出るラベル同士が重ならないよう、表示Y座標を整える。
             * 名前と件数・割合の2行ぶんを考慮し、ラベル間は48px以上空ける。
             */
            function layoutAnnotations() {
                const labelTop = 46;
                const labelBottom = 276;
                const labelGap = 48;

                ['left', 'right'].forEach(function (side) {
                    /*
                     * 各円弧の本来のラベル位置を求め、
                     * 左右どちらに配置するかでグループ分けする。
                     */
                    const sideSegments = segments
                        .map(function (segment) {
                            const elbow = polarPoint(
                                segment.middleAngle,
                                radius + (strokeWidth / 2) + 12
                            );

                            return {
                                segment: segment,
                                elbow: elbow,
                                isRight: elbow.x >= centerX,
                                preferredY: elbow.y,
                            };
                        })
                        .filter(function (item) {
                            return item.isRight === (side === 'right');
                        })
                        .sort(function (a, b) {
                            return a.preferredY - b.preferredY;
                        });

                    /*
                     * 上から順に、前のラベルから最低48px離した位置へ置く。
                     * 本来の位置をできるだけ維持しつつ、重なりだけを解消する。
                     */
                    let previousY = labelTop - labelGap;

                    sideSegments.forEach(function (item) {
                        item.labelY = Math.max(
                            item.preferredY,
                            previousY + labelGap
                        );

                        previousY = item.labelY;
                    });

                    /*
                     * 下端を越えた場合は、下から上へ押し戻す。
                     * これにより、すべてのラベルをSVGの表示範囲内へ収める。
                     */
                    let nextY = labelBottom + labelGap;

                    for (let index = sideSegments.length - 1; index >= 0; index -= 1) {
                        sideSegments[index].labelY = Math.min(
                            sideSegments[index].labelY,
                            nextY - labelGap
                        );

                        nextY = sideSegments[index].labelY;
                    }

                    /*
                     * 次の表示処理で使えるよう、円弧ごとに配置結果を保存する。
                     */
                    sideSegments.forEach(function (item) {
                        item.segment.annotationElbow = item.elbow;
                        item.segment.annotationIsRight = item.isRight;
                        item.segment.annotationY = item.labelY;
                    });
                });
            }

            // すべての円弧について、ラベルの衝突しない位置を先に計算する
            layoutAnnotations();

            /*
             * 先に準備した中央の「計・合計件数・件」をSVGへ追加する。
             * 初期状態ではopacity: 0なので、まだ画面には見えない。
             */
            centerTexts.forEach(function (text) {
                svg.appendChild(text);
            });

            /*
             * すべての円弧・ガイド線・ラベルの表示後に、
             * 中央の合計表示を見せる。
             */
            function showCenterTexts() {
                centerTexts.forEach(function (text) {
                    /*
                     * OSで動きを減らす設定が有効なら、
                     * アニメーションせず、すぐに表示する。
                     */
                    if (reduceMotion) {
                        text.style.opacity = '1';
                        return;
                    }

                    /*
                     * 通常時は、少し下から上へ現れるように表示する。
                     * fill: forwards により、表示完了後の状態を維持する。
                     */
                    text.animate(
                        [
                            {
                                opacity: 0,
                                transform: 'translateY(4px)',
                            },
                            {
                                opacity: 1,
                                transform: 'translateY(0)',
                            },
                        ],
                        {
                            duration: 250,
                            fill: 'forwards',
                            easing: 'ease-out',
                        }
                    );
                });
            }

            /*
             * 1つの円弧に対応するガイド線とラベルを表示する。
             * 円弧の中央位置から外側へ線を伸ばし、
             * 区分名・件数・割合をその先に表示する。
             */
            function showAnnotation(segment) {
                /*
                 * スマホではCSSでSVG内ラベルを隠す設計のため、
                 * ガイド線・ラベルを作らずに処理を終える。
                 * 区分名・件数・割合は既存凡例で確認できる。
                 */
                if (isMobile) {
                    return Promise.resolve();
                }

                // 円弧の外周上にある、ガイド線の開始座標
                const start = polarPoint(
                    segment.middleAngle,
                    radius + (strokeWidth / 2)
                );

                /*
                 * 事前に計算した衝突しないラベル位置を使う。
                 * elbowは円弧から線が伸び始める位置、
                 * annotationYは線の終点とラベルを置くY座標。
                 */
                const elbow = segment.annotationElbow;
                const isRight = segment.annotationIsRight;
                const annotationY = segment.annotationY;

                /*
                 * 左右の余白に合わせた、ガイド線終点とラベル位置。
                 * 線の終点と色丸の間には、8px程度のすき間を取る。
                 */
                const lineEndX = isRight ? 337 : 33;
                const textX = isRight ? 360 : 10;
                const textAnchor = isRight ? 'start' : 'end';

                /*
                 * 「円弧の中央 → 外側 → 横方向」の順に伸びるガイド線。
                 * 最初は線を隠し、後で線を描くアニメーションを行う。
                 */
                const line = createSvgElement('path', {
                    d:
                        'M ' + start.x + ' ' + start.y +
                        ' L ' + elbow.x + ' ' + elbow.y +
                        ' L ' + lineEndX + ' ' + annotationY,
                    class: 'reaction-donut-line',
                });

                /*
                 * ガイド線の先に表示する、色丸・区分名・件数・割合のグループ。
                 * グループ全体を非表示で作り、線の完成後に表示する。
                 */
                const labelGroup = createSvgElement('g', {
                    class: 'reaction-donut-annotation',
                });

                // 円弧と同じ色の小さな丸
                const dot = createSvgElement('circle', {
                    cx: isRight ? textX - 10 : textX + 10,
                    cy: annotationY - 5,
                    r: 5,
                    fill: segment.reaction.color,
                });

                // 例：ナイストライ
                const name = createSvgElement('text', {
                    x: textX,
                    y: annotationY,
                    'text-anchor': textAnchor,
                    class: 'reaction-donut-label-name',
                });

                // 例：8件（40%）
                const value = createSvgElement('text', {
                    x: textX,
                    y: annotationY + 19,
                    'text-anchor': textAnchor,
                    class: 'reaction-donut-label-value',
                });

                name.textContent = segment.reaction.label;
                value.textContent =
                    segment.reaction.count + '件（' +
                    segment.reaction.percentage + '%）';

                labelGroup.style.opacity = '0';
                labelGroup.appendChild(dot);
                labelGroup.appendChild(name);
                labelGroup.appendChild(value);

                svg.appendChild(line);
                svg.appendChild(labelGroup);

                /*
                 * 線の全長を使い、最初は見えない状態にする。
                 * strokeDashoffsetを0へ動かすことで、線が伸びるように見せる。
                 */
                const pathLength = line.getTotalLength();
                line.style.strokeDasharray = pathLength;
                line.style.strokeDashoffset = pathLength;

                /*
                 * 動きを減らす設定では、ガイド線とラベルを即時表示する。
                 */
                if (reduceMotion) {
                    line.style.strokeDashoffset = '0';
                    labelGroup.style.opacity = '1';
                    return Promise.resolve();
                }

                // まず300msかけてガイド線を伸ばす
                line.animate(
                    [
                        { strokeDashoffset: pathLength },
                        { strokeDashoffset: 0 },
                    ],
                    {
                        duration: 300,
                        fill: 'forwards',
                        easing: 'ease-out',
                    }
                );

                /*
                 * 線の完成後、220msかけてラベルを表示する。
                 * Promiseを返すことで、次の区分へ進むタイミングを制御する。
                 */
                return wait(300).then(function () {
                    labelGroup.animate(
                        [
                            {
                                opacity: 0,
                                transform: 'translateY(4px)',
                            },
                            {
                                opacity: 1,
                                transform: 'translateY(0)',
                            },
                        ],
                        {
                            duration: 220,
                            fill: 'forwards',
                            easing: 'ease-out',
                        }
                    );

                    return wait(220);
                });
            }

            /*
             * SVGを表示領域へ追加し、リアクションごとの演出を順番に実行する。
             */
            async function playAnimation() {
                /*
                 * ここで初めてSVG全体を画面へ追加する。
                 * SVGを追加する表示領域は、後の手順でHTML側に用意する。
                 */
                chart.appendChild(svg);

                /*
                 * リアクションが0件なら、灰色の背景リングと中央合計だけを表示する。
                 * 色付き円弧・ガイド線・ラベルのアニメーションは行わない。
                 */
                if (visibleReactions.length === 0) {
                    showCenterTexts();
                    return;
                }

                /*
                 * 件数の多い順に、1区分ずつ処理する。
                 * 円弧が完成してから線とラベルを表示し、
                 * その後に次の区分へ進む。
                 */
                for (const segment of segments) {
                    if (reduceMotion) {
                        /*
                         * 動きを減らす設定では、
                         * 円弧を完成状態で即時表示する。
                         */
                        segment.circle.style.strokeDasharray =
                            segment.arcLength + ' ' + circumference;
                    } else {
                        /*
                         * 円弧を0から指定割合まで650msで伸ばす。
                         * fill: forwards により、完成した円弧をそのまま残す。
                         */
                        segment.circle.animate(
                            [
                                {
                                    strokeDasharray:
                                        '0 ' + circumference,
                                },
                                {
                                    strokeDasharray:
                                        segment.arcLength +
                                        ' ' + circumference,
                                },
                            ],
                            {
                                duration: 650,
                                fill: 'forwards',
                                easing: 'ease-out',
                            }
                        );

                        // 円弧の完成を待ってから、線とラベルを表示する
                        await wait(650);
                    }

                    // 円弧の中央から線を伸ばし、区分・件数・割合を表示する
                    await showAnnotation(segment);

                    /*
                     * 次の区分へ進む前に、少しだけ間を置く。
                     * 動きを減らす設定では待たない。
                     */
                    if (!reduceMotion) {
                        await wait(120);
                    }
                }

                // 全区分の表示後、中央に合計件数を表示する
                showCenterTexts();
            }

            // ページ読込後に、ドーナツの演出を開始する
            playAnimation();

        });
    </script>
@endpush