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
exports.validateCaptchaInfo = exports.validateCaptcha = exports.shouldValidate = void 0;
const FieldError_1 = require("../../../error/FieldError");
const error_1 = require("../../../error");
const shouldValidate = (context) => {
    const { component } = context;
    if (component.type === 'recaptcha') {
        return true;
    }
    return false;
};
exports.shouldValidate = shouldValidate;
const validateCaptcha = (context) => __awaiter(void 0, void 0, void 0, function* () {
    var _a;
    const { value, config, component } = context;
    if (!(0, exports.shouldValidate)(context)) {
        return null;
    }
    if (!config || !config.database) {
        throw new error_1.ProcessorError("Can't test for recaptcha success without a database config object", context, 'validate:validateCaptcha');
    }
    try {
        if (!value || !value.token) {
            return new FieldError_1.FieldError('captchaTokenNotSpecified', context, 'catpcha');
        }
        if (!value.success) {
            return new FieldError_1.FieldError('captchaTokenValidation', context, 'captcha');
        }
        const captchaResult = yield ((_a = config.database) === null || _a === void 0 ? void 0 : _a.validateCaptcha(value.token));
        return (captchaResult === true) ? null : new FieldError_1.FieldError('captchaFailure', context, 'captcha');
    }
    catch (err) {
        throw new error_1.ProcessorError(err.message || err, context, 'validate:validateCaptcha');
    }
});
exports.validateCaptcha = validateCaptcha;
exports.validateCaptchaInfo = {
    name: 'validateCaptcha',
    process: exports.validateCaptcha,
    shouldProcess: exports.shouldValidate,
};
