function prepareUploadUIInfo() {
    let jsonFileUuids = document.getElementById("file-upload-ui-load-info-fileUuids").value;
    let jsonFileNames = document.getElementById("file-upload-ui-load-info-fileNames").value;

    // sessionStorageに保存する。
    sessionStorage.setItem('uploadUiRestoreInfoFileUuids', jsonFileUuids);
    sessionStorage.setItem('uploadUiRestoreInfoFileNames', jsonFileNames);
}
