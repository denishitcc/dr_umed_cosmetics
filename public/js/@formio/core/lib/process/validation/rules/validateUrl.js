"use strict";
var __awaiter = (this && this.__awaiter) || function (thisArg, _arguments, P, generator) {
    function adopt(value) { return value instanceof P ? value : new P(function (resolve) { resolve(value); }); }
    return new (P || (P = Promise))(function (resolve, reject) {
        function fulfilled(value) { try { step(generator.next(value)); } catch (e) { reject(e); } }
        function rejected(value) { try { step(generator["throw"](value)); } catch (e) { reject(e); } }
        function step(result) { result.done ? resolve(result.value) : adopt(result.value).then(fulfilled, rejected); }
        step((generator = generator.apply(thisArg, _arguments || [])).next());
    });
};
Object.defineProperty(exports, "__esModule", { value: true });
exports.validateUrlInfo = exports.validateUrl = exports.validateUrlSync = exports.shouldValidate = void 0;
const error_1 = require("../../../error");
const isUrlComponent = (component) => {
    return component && component.type === 'url';
};
const shouldValidate = (context) => {
    const { component, value } = context;
    if (!isUrlComponent(component)) {
        return false;
    }
    if (!value) {
        return false;
    }
    return true;
};
exports.shouldValidate = shouldValidate;
const validateUrlSync = (context) => {
    const { value } = context;
    if (!(0, exports.shouldValidate)(context)) {
        return null;
    }
    const error = new error_1.FieldError('invalid_url', context, 'url');
    if (typeof value !== 'string') {
        return error;
    }
    // From https://stackoverflow.com/questions/8667070/javascript-regular-expression-to-validate-url
    const re = /^(?:(?:(?:https?|ftp):)?\/\/)?(?:\S+(?::\S*)?@)?(?:(?!(?:10|127)(?:\.\d{1,3}){3})(?!(?:169\.254|192\.168)(?:\.\d{1,3}){2})(?!172\.(?:1[6-9]|2\d|3[0-1])(?:\.\d{1,3}){2})(?:[1-9]\d?|1\d\d|2[01]\d|22[0-3])(?:\.(?:1?\d{1,2}|2[0-4]\d|25[0-5])){2}(?:\.(?:[1-9]\d?|1\d\d|2[0-4]\d|25[0-4]))|(?:(?:[a-z\u00a1-\uffff0-9]-*)*[a-z\u00a1-\uffff0-9]+)(?:\.(?:[a-z\u00a1-\uffff0-9]-*)*[a-z\u00a1-\uffff0-9]+)*(?:\.(?:[a-z\u00a1-\uffff]{2,})))(?::\d{2,5})?(?:[/?#]\S*)?$/i;
    // From http://stackoverflow.com/questions/46155/validate-email-address-in-javascript
    const emailRe = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    // Allow urls to be valid if the component is pristine and no value is provided.
    return (re.test(value) && !emailRe.test(value)) ? null : error;
};
exports.validateUrlSync = validateUrlSync;
const validateUrl = (context) => __awaiter(void 0, void 0, void 0, function* () {
    return (0, exports.validateUrlSync)(context);
});
exports.validateUrl = validateUrl;
exports.validateUrlInfo = {
    name: 'validateUrl',
    process: exports.validateUrl,
    processSync: exports.validateUrlSync,
    shouldProcess: exports.shouldValidate
};
