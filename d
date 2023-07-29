[1mdiff --git a/resources/lang/ja/auth.php b/resources/lang/ja/auth.php[m
[1mdeleted file mode 100644[m
[1mindex e5506df..0000000[m
[1m--- a/resources/lang/ja/auth.php[m
[1m+++ /dev/null[m
[36m@@ -1,19 +0,0 @@[m
[31m-<?php[m
[31m-[m
[31m-return [[m
[31m-[m
[31m-    /*[m
[31m-    |--------------------------------------------------------------------------[m
[31m-    | Authentication Language Lines[m
[31m-    |--------------------------------------------------------------------------[m
[31m-    |[m
[31m-    | The following language lines are used during authentication for various[m
[31m-    | messages that we need to display to the user. You are free to modify[m
[31m-    | these language lines according to your application's requirements.[m
[31m-    |[m
[31m-    */[m
[31m-[m
[31m-    'failed' => 'These credentials do not match our records.',[m
[31m-    'throttle' => 'Too many login attempts. Please try again in :seconds seconds.',[m
[31m-[m
[31m-];[m
[1mdiff --git a/resources/lang/ja/pagination.php b/resources/lang/ja/pagination.php[m
[1mdeleted file mode 100644[m
[1mindex d481411..0000000[m
[1m--- a/resources/lang/ja/pagination.php[m
[1m+++ /dev/null[m
[36m@@ -1,19 +0,0 @@[m
[31m-<?php[m
[31m-[m
[31m-return [[m
[31m-[m
[31m-    /*[m
[31m-    |--------------------------------------------------------------------------[m
[31m-    | Pagination Language Lines[m
[31m-    |--------------------------------------------------------------------------[m
[31m-    |[m
[31m-    | The following language lines are used by the paginator library to build[m
[31m-    | the simple pagination links. You are free to change them to anything[m
[31m-    | you want to customize your views to better match your application.[m
[31m-    |[m
[31m-    */[m
[31m-[m
[31m-    'previous' => '&laquo; Previous',[m
[31m-    'next' => 'Next &raquo;',[m
[31m-[m
[31m-];[m
[1mdiff --git a/resources/lang/ja/passwords.php b/resources/lang/ja/passwords.php[m
[1mdeleted file mode 100644[m
[1mindex 724de4b..0000000[m
[1m--- a/resources/lang/ja/passwords.php[m
[1m+++ /dev/null[m
[36m@@ -1,22 +0,0 @@[m
[31m-<?php[m
[31m-[m
[31m-return [[m
[31m-[m
[31m-    /*[m
[31m-    |--------------------------------------------------------------------------[m
[31m-    | Password Reset Language Lines[m
[31m-    |--------------------------------------------------------------------------[m
[31m-    |[m
[31m-    | The following language lines are the default lines which match reasons[m
[31m-    | that are given by the password broker for a password update attempt[m
[31m-    | has failed, such as for an invalid token or invalid new password.[m
[31m-    |[m
[31m-    */[m
[31m-[m
[31m-    'reset' => 'Your password has been reset!',[m
[31m-    'sent' => 'We have e-mailed your password reset link!',[m
[31m-    'throttled' => 'Please wait before retrying.',[m
[31m-    'token' => 'This password reset token is invalid.',[m
[31m-    'user' => "We can't find a user with that e-mail address.",[m
[31m-[m
[31m-];[m
[1mdiff --git a/resources/lang/ja/validation.php b/resources/lang/ja/validation.php[m
[1mdeleted file mode 100644[m
[1mindex c379775..0000000[m
[1m--- a/resources/lang/ja/validation.php[m
[1m+++ /dev/null[m
[36m@@ -1,150 +0,0 @@[m
[31m-<?php[m
[31m-[m
[31m-return [[m
[31m-[m
[31m-    /*[m
[31m-    |--------------------------------------------------------------------------[m
[31m-    | Validation Language Lines[m
[31m-    |--------------------------------------------------------------------------[m
[31m-    |[m
[31m-    | The following language lines contain the default error messages used by[m
[31m-    | the validator class. Some of these rules have multiple versions such[m
[31m-    | as the size rules. Feel free to tweak each of these messages here.[m
[31m-    |[m
[31m-    */[m
[31m-[m
[31m-    'accepted' => ':attributeを承認してください。',[m
[31m-    'active_url' => ':attributeは、有効なURLではありません。',[m
[31m-    'after' => ':attributeには、:dateより後の日付を指定してください。',[m
[31m-    'after_or_equal' => ':attributeには、:date以降の日付を指定してください。',[m
[31m-    'alpha' => ':attributeには、アルファベッドのみ使用できます。',[m
[31m-    'alpha_dash' => ":attributeには、英数字('A-Z','a-z','0-9')とハイフンと下線('-','_')が使用できます。",[m
[31m-    'alpha_num' => ":attributeには、英数字('A-Z','a-z','0-9')が使用できます。",[m
[31m-    'array' => ':attributeには、配列を指定してください。',[m
[31m-    'before' => ':attributeには、:dateより前の日付を指定してください。',[m
[31m-    'before_or_equal' => ':attributeには、:date以前の日付を指定してください。',[m
[31m-    'between' => [[m
[31m-        'numeric' => ':attributeには、:minから、:maxまでの数字を指定してください。',[m
[31m-        'file' => ':attributeには、:min KBから:max KBまでのサイズのファイルを指定してください。',[m
[31m-        'string' => ':attributeは、:min文字から:max文字にしてください。',[m
[31m-        'array' => ':attributeの項目は、:min個から:max個にしてください。',[m
[31m-    ],[m
[31m-    'boolean' => ":attributeには、'true'か'false'を指定してください。",[m
[31m-    'confirmed' => ':attributeと:attribute確認が一致しません。',[m
[31m-    'date' => ':attributeは、正しい日付ではありません。',[m
[31m-    'date_equals' => ':attributeは:dateに等しい日付でなければなりません。',[m
[31m-    'date_format' => ":attributeの形式は、':format'と合いません。",[m
[31m-    'different' => ':attributeと:otherには、異なるものを指定してください。',[m
[31m-    'digits' => ':attributeは、:digits桁にしてください。',[m
[31m-    'digits_between' => ':attributeは、:min桁から:max桁にしてください。',[m
[31m-    'dimensions' => ':attributeの画像サイズが無効です',[m
[31m-    'distinct' => ':attributeの値が重複しています。',[m
[31m-    'email' => ':attributeは、有効なメールアドレス形式で指定してください。',[m
[31m-    'ends_with' => 'The :attribute must end with one of the following: :values',[m
[31m-    'exists' => '選択された:attributeは、有効ではありません。',[m
[31m-    'file' => ':attributeはファイルでなければいけません。',[m
[31m-    'filled' => ':attributeは必須です。',[m
[31m-    'gt' => [[m
[31m-        'numeric' => ':attributeは、:valueより大きくなければなりません。',[m
[31m-        'file' => ':attributeは、:value KBより大きくなければなりません。',[m
[31m-        'string' => ':attributeは、:value文字より大きくなければなりません。',[m
[31m-        'array' => ':attributeの項目数は、:value個より大きくなければなりません。',[m
[31m-    ],[m
[31m-    'gte' => [[m
[31m-        'numeric' => ':attributeは、:value以上でなければなりません。',[m
[31m-        'file' => ':attributeは、:value KB以上でなければなりません。',[m
[31m-        'string' => ':attributeは、:value文字以上でなければなりません。',[m
[31m-        'array' => ':attributeの項目数は、:value個以上でなければなりません。',[m
[31m-    ],[m
[31m-    'image' => ':attributeには、画像を指定してください。',[m
[31m-    'in' => '選択された:attributeは、有効ではありません。',[m
[31m-    'in_array' => ':attributeが:otherに存在しません。',[m
[31m-    'integer' => ':attributeには、整数を指定してください。',[m
[31m-    'ip' => ':attributeには、有効なIPアドレスを指定してください。',[m
[31m-    'ipv4' => ':attributeはIPv4アドレスを指定してください。',[m
[31m-    'ipv6' => ':attributeはIPv6アドレスを指定してください。',[m
[31m-    'json' => ':attributeには、有効なJSON文字列を指定してください。',[m
[31m-    'lt' => [[m
[31m-        'numeric' => ':attributeは、:valueより小さくなければなりません。',[m
[31m-        'file' => ':attributeは、:value KBより小さくなければなりません。',[m
[31m-        'string' => ':attributeは、:value文字より小さくなければなりません。',[m
[31m-        'array' => ':attributeの項目数は、:value個より小さくなければなりません。',[m
[31m-    ],[m
[31m-    'lte' => [[m
[31m-        'numeric' => ':attributeは、:value以下でなければなりません。',[m
[31m-        'file' => ':attributeは、:value KB以下でなければなりません。',[m
[31m-        'string' => ':attributeは、:value文字以下でなければなりません。',[m
[31m-        'array' => ':attributeの項目数は、:value個以下でなければなりません。',[m
[31m-    ],[m
[31m-    'max' => [[m
[31m-        'numeric' => ':attributeには、:max以下の数字を指定してください。',[m
[31m-        'file' => ':attributeには、:max KB以下のファイルを指定してください。',[m
[31m-        'string' => ':attributeは、:max文字以下にしてください。',[m
[31m-        'array' => ':attributeの項目は、:max個以下にしてください。',[m
[31m-    ],[m
[31m-    'mimes' => ':attributeには、:valuesタイプのファイルを指定してください。',[m
[31m-    'mimetypes' => ':attributeには、:valuesタイプのファイルを指定してください。',[m
[31m-    'min' => [[m
[31m-        'numeric' => ':attributeには、:min以上の数字を指定してください。',[m
[31m-        'file' => ':attributeには、:min KB以上のファイルを指定してください。',[m
[31m-        'string' => ':attributeは、:min文字以上にしてください。',[m
[31m-        'array' => ':attributeの項目は、:min個以上にしてください。',[m
[31m-    ],[m
[31m-    'not_in' => '選択された:attributeは、有効ではありません。',[m
[31m-    'not_regex' => ':attributeの形式が無効です。',[m
[31m-    'numeric' => ':attributeには、数字を指定してください。',[m
[31m-    'password' => ':attributeが間違っています',[m
[31m-    'present' => ':attributeが存在している必要があります。',[m
[31m-    'regex' => ':attributeには、有効な正規表現を指定してください。',[m
[31m-    'required' => ':attributeは、必ず指定してください。',[m
[31m-    'required_if' => ':otherが:valueの場合、:attributeを指定してください。',[m
[31m-    'required_unless' => ':otherが:values以外の場合、:attributeを指定してください。',[m
[31m-    'required_with' => ':valuesが指定されている場合、:attributeも指定してください。',[m
[31m-    'required_with_all' => ':valuesが全て指定されている場合、:attributeも指定してください。',[m
[31m-    'required_without' => ':valuesが指定されていない場合、:attributeを指定してください。',[m
[31m-    'required_without_all' => ':valuesが全て指定されていない場合、:attributeを指定してください。',[m
[31m-    'same' => ':attributeと:otherが一致しません。',[m
[31m-    'size' => [[m
[31m-        'numeric' => ':attributeには、:sizeを指定してください。',[m
[31m-        'file' => ':attributeには、:size KBのファイルを指定してください。',[m
[31m-        'string' => ':attributeは、:size文字にしてください。',[m
[31m-        'array' => ':attributeの項目は、:size個にしてください。',[m
[31m-    ],[m
[31m-    'starts_with' => ':attributeは、次のいずれかで始まる必要があります。:values',[m
[31m-    'string' => ':attributeには、文字を指定してください。',[m
[31m-    'timezone' => ':attributeには、有効なタイムゾーンを指定してください。',[m
[31m-    'unique' => '指定の:attributeは既に使用されています。',[m
[31m-    'uploaded' => ':attributeのアップロードに失敗しました。',[m
[31m-    'url' => ':attributeは、有効なURL形式で指定してください。',[m
[31m-    'uuid' => ':attributeは、有効なUUIDでなければなりません。',[m
[31m-    /*[m
[31m-    |--------------------------------------------------------------------------[m
[31m-    | Custom Validation Language Lines[m
[31m-    |--------------------------------------------------------------------------[m
[31m-    |[m
[31m-    | Here you may specify custom validation messages for attributes using the[m
[31m-    | convention "attribute.rule" to name the lines. This makes it quick to[m
[31m-    | specify a specific custom language line for a given attribute rule.[m
[31m-    |[m
[31m-    */[m
[31m-    'custom' => [[m
[31m-        'attribute-name' => [[m
[31m-            'rule-name' => 'custom-message',[m
[31m-        ],[m
[31m-    ],[m
[31m-    /*[m
[31m-    |--------------------------------------------------------------------------[m
[31m-    | Custom Validation Attributes[m
[31m-    |--------------------------------------------------------------------------[m
[31m-    |[m
[31m-    | The following language lines are used to swap our attribute placeholder[m
[31m-    | with something more reader friendly such as "E-Mail Address" instead[m
[31m-    | of "email". This simply helps us make our message more expressive.[m
[31m-    |[m
[31m-    */[m
[31m-    'attributes' => [[m
[31m-        'name' => '名前',[m
[31m-        'email' => 'メールアドレス',[m
[31m-        'password' => 'パスワード',[m
[31m-    ],[m
[31m-];[m
\ No newline at end of file[m
[1mdiff --git a/resources/views/auth/login.blade.php b/resources/views/auth/login.blade.php[m
[1mindex 93d471d..0abcfb4 100644[m
[1m--- a/resources/views/auth/login.blade.php[m
[1m+++ b/resources/views/auth/login.blade.php[m
[36m@@ -10,6 +10,15 @@[m
 <div class="text-center">[m
     <h3 class="login_title text-left d-inline-block mt-5">ログイン</h3>[m
 </div>[m
[32m+[m
[32m+[m[32m@if (count($errors) > 0)[m
[32m+[m[32m    <ul class="alert alert-danger" role="alert">[m
[32m+[m[32m        @foreach ($errors->all() as $error)[m
[32m+[m[32m            <li class="ml-4">{{ $error }}</li>[m
[32m+[m[32m        @endforeach[m
[32m+[m[32m    </ul>[m
[32m+[m[32m@endif[m
[32m+[m
 <div class="row mt-5 mb-5">[m
     <div class="col-sm-6 offset-sm-3">[m
         <form method="POST" action="{{ route('login.post') }}">[m
[1mdiff --git a/resources/views/commons/error_messages.blade.php b/resources/views/commons/error_messages.blade.php[m
[1mdeleted file mode 100644[m
[1mindex 0694c7f..0000000[m
[1m--- a/resources/views/commons/error_messages.blade.php[m
[1m+++ /dev/null[m
[36m@@ -1,7 +0,0 @@[m
[31m-@if (count($errors) > 0)[m
[31m-    <ul class="alert alert-danger" role="alert">[m
[31m-        @foreach ($errors->all() as $error)[m
[31m-            <li class="ml-4">{{ $error }}</li>[m
[31m-        @endforeach[m
[31m-    </ul>[m
[31m-@endif[m
\ No newline at end of file[m
[1mdiff --git a/resources/views/layouts/app.blade.php b/resources/views/layouts/app.blade.php[m
[1mindex 943c8bb..8a5713f 100644[m
[1m--- a/resources/views/layouts/app.blade.php[m
[1m+++ b/resources/views/layouts/app.blade.php[m
[36m@@ -9,7 +9,6 @@[m
     <body>[m
         @include('commons.header')[m
         <div class="container">[m
[31m-        @include('commons.error_messages')[m
         @yield('content')[m
         </div>[m
         @include('commons.footer')[m
