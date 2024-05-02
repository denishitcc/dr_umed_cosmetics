"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
const xhr_1 = require("./xhr");
function googledrive(formio) {
    return {
        uploadFile(file, fileName, dir, progressCallback, url, options, fileKey, groupPermissions, groupId, abortCallback) {
            return new Promise(((resolve, reject) => {
                // Send the file with data.
                const xhr = new XMLHttpRequest();
                if (typeof progressCallback === 'function') {
                    xhr.upload.onprogress = progressCallback;
                }
                if (typeof abortCallback === 'function') {
                    abortCallback(() => xhr.abort());
                }
                const fd = new FormData();
                fd.append('name', fileName);
                fd.append('dir', dir);
                fd.append('file', file);
                // Fire on network error.
                xhr.onerror = (err) => {
                    err.networkError = true;
                    reject(err);
                };
                xhr.onload = () => {
                    if (xhr.status >= 200 && xhr.status < 300) {
                        const response = JSON.parse(xhr.response);
                        response.storage = 'googledrive';
                        response.size = file.size;
                        response.type = file.type;
                        response.groupId = groupId;
                        response.groupPermissions = groupPermissions;
                        resolve(response);
                    }
                    else {
                        reject(xhr.response || 'Unable to upload file');
                    }
                };
                xhr.onabort = reject;
                xhr.open('POST', `${formio.formUrl}/storage/gdrive`);
                (0, xhr_1.setXhrHeaders)(formio, xhr);
                const token = formio.getToken();
                if (token) {
                    xhr.setRequestHeader('x-jwt-token', token);
                }
                xhr.send(fd);
            }));
        },
        downloadFile(file) {
            const token = formio.getToken();
            file.url =
                `${formio.formUrl}/storage/gdrive?fileId=${file.id}&fileName=${file.originalName}${token ? `&x-jwt-token=${token}` : ''}`;
            return Promise.resolve(file);
        },
        deleteFile: function deleteFile(fileInfo) {
            var url = ''.concat(formio.formUrl, `/storage/gdrive?id=${fileInfo.id}&name=${fileInfo.originalName}`);
            return formio.makeRequest('', url, 'delete');
        },
    };
}
googledrive.title = 'Google Drive';
exports.default = googledrive;
