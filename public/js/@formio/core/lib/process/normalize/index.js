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
var __importDefault = (this && this.__importDefault) || function (mod) {
    return (mod && mod.__esModule) ? mod : { "default": mod };
};
Object.defineProperty(exports, "__esModule", { value: true });
exports.normalizeProcessInfo = exports.normalizeProcessSync = exports.normalizeProcess = void 0;
const get_1 = __importDefault(require("lodash/get"));
const set_1 = __importDefault(require("lodash/set"));
const isString_1 = __importDefault(require("lodash/isString"));
const toString_1 = __importDefault(require("lodash/toString"));
const isNil_1 = __importDefault(require("lodash/isNil"));
const isObject_1 = __importDefault(require("lodash/isObject"));
const dayjs_1 = __importDefault(require("dayjs"));
const customParseFormat_1 = __importDefault(require("dayjs/plugin/customParseFormat"));
dayjs_1.default.extend(customParseFormat_1.default);
const isAddressComponent = (component) => component.type === "address";
const isDayComponent = (component) => component.type === "day";
const isEmailComponent = (component) => component.type === "email";
const isRadioComponent = (component) => component.type === "radio";
const isRecaptchaComponent = (component) => component.type === "recaptcha";
const isSelectComponent = (component) => component.type === "select";
const isSelectBoxesComponent = (component) => component.type === "selectboxes";
const isTagsComponent = (component) => component.type === "tags";
const isTextFieldComponent = (component) => component.type === "textfield";
const isTimeComponent = (component) => component.type === "time";
const normalizeAddressComponentValue = (component, value) => {
    if (!component.multiple && Boolean(component.enableManualMode) && value && !value.mode) {
        return {
            mode: 'autocomplete',
            address: value,
        };
    }
    return value;
};
const getLocaleDateFormatInfo = (locale = 'en') => {
    const formatInfo = {};
    const day = 21;
    const exampleDate = new Date(2017, 11, day);
    const localDateString = exampleDate.toLocaleDateString(locale);
    formatInfo.dayFirst = localDateString.slice(0, 2) === day.toString();
    return formatInfo;
};
const getLocaleDayFirst = (component, form) => {
    var _a;
    if (component.useLocaleSettings) {
        return getLocaleDateFormatInfo((_a = form.options) === null || _a === void 0 ? void 0 : _a.language).dayFirst;
    }
    return component.dayFirst;
};
const normalizeDayComponentValue = (component, form, value) => {
    // TODO: this is a quick and dirty port of the Day component's normalizeValue method, may need some updates
    const valueMask = /^\d{2}\/\d{2}\/\d{4}$/;
    const isDayFirst = getLocaleDayFirst(component, form);
    const showDay = !(0, get_1.default)(component, 'fields.day.hide', false);
    const showMonth = !(0, get_1.default)(component, 'fields.month.hide', false);
    const showYear = !(0, get_1.default)(component, 'fields.year.hide', false);
    if (!value || valueMask.test(value)) {
        return value;
    }
    let dateParts = [];
    const valueParts = value.split('/');
    const [DAY, MONTH, YEAR] = component.dayFirst ? [0, 1, 2] : [1, 0, 2];
    const defaultValue = component.defaultValue ? component.defaultValue.split('/') : '';
    const getNextPart = (shouldTake, defaultValue) => dateParts.push(shouldTake ? valueParts.shift() : defaultValue);
    if (isDayFirst) {
        getNextPart(showDay, defaultValue ? defaultValue[DAY] : '00');
    }
    getNextPart(showMonth, defaultValue ? defaultValue[MONTH] : '00');
    if (!isDayFirst) {
        getNextPart(showDay, defaultValue ? defaultValue[DAY] : '00');
    }
    getNextPart(showYear, defaultValue ? defaultValue[YEAR] : '0000');
    return dateParts.join('/');
};
const normalizeRadioComponentValue = (value) => {
    const isEquivalent = (0, toString_1.default)(value) === Number(value).toString();
    if (!isNaN(parseFloat(value)) && isFinite(value) && isEquivalent) {
        return +value;
    }
    if (value === 'true') {
        return true;
    }
    if (value === 'false') {
        return false;
    }
    return value;
};
const normalizeSingleSelectComponentValue = (component, value) => {
    if ((0, isNil_1.default)(value)) {
        return;
    }
    const valueIsObject = (0, isObject_1.default)(value);
    //check if value equals to default emptyValue
    if (valueIsObject && Object.keys(value).length === 0) {
        return value;
    }
    const dataType = component.dataType || 'auto';
    const normalize = {
        value,
        number() {
            const numberValue = Number(this.value);
            const isEquivalent = value.toString() === numberValue.toString();
            if (!Number.isNaN(numberValue) && Number.isFinite(numberValue) && value !== '' && isEquivalent) {
                this.value = numberValue;
            }
            return this;
        },
        boolean() {
            if ((0, isString_1.default)(this.value) && (this.value.toLowerCase() === 'true' || this.value.toLowerCase() === 'false')) {
                this.value = (this.value.toLowerCase() === 'true');
            }
            return this;
        },
        string() {
            this.value = String(this.value);
            return this;
        },
        object() {
            return this;
        },
        auto() {
            if ((0, isObject_1.default)(this.value)) {
                this.value = this.object().value;
            }
            else {
                this.value = this.string().number().boolean().value;
            }
            return this;
        }
    };
    try {
        return normalize[dataType]().value;
    }
    catch (err) {
        console.warn('Failed to normalize value', err);
        return value;
    }
};
const normalizeSelectComponentValue = (component, value) => {
    if (component.multiple && Array.isArray(value)) {
        return value.map((singleValue) => normalizeSingleSelectComponentValue(component, singleValue));
    }
    return normalizeSingleSelectComponentValue(component, value);
};
const normalizeSelectBoxesComponentValue = (value) => {
    if (!value) {
        value = {};
    }
    if (typeof value !== 'object') {
        if (typeof value === 'string') {
            return {
                [value]: true
            };
        }
        else {
            return {};
        }
    }
    if (Array.isArray(value)) {
        return value.reduce((acc, curr) => {
            return Object.assign(Object.assign({}, acc), { [curr]: true });
        }, {});
    }
    return value;
};
const normalizeTagsComponentValue = (component, value) => {
    const delimiter = component.delimeter || ',';
    if ((!component.hasOwnProperty('storeas') || component.storeas === 'string') && Array.isArray(value)) {
        return value.join(delimiter);
    }
    else if (component.storeas === 'array' && typeof value === 'string') {
        return value.split(delimiter).filter(result => result);
    }
    return value;
};
const normalizeMaskValue = (component, defaultValues, value, path) => {
    if (component.inputMasks && component.inputMasks.length > 0) {
        if (!value || typeof value !== 'object') {
            return {
                value: value,
                maskName: component.inputMasks[0].label
            };
        }
        if (!value.value) {
            const defaultValue = defaultValues === null || defaultValues === void 0 ? void 0 : defaultValues.find((defaultValue) => defaultValue.path === path);
            value.value = Array.isArray(defaultValue) && defaultValue.length > 0 ? defaultValue[0] : defaultValue;
        }
    }
    return value;
};
const normalizeTextFieldComponentValue = (component, defaultValues, value, path) => {
    // If the component has truncate multiple spaces enabled, then normalize the value to remove extra spaces.
    if (component.truncateMultipleSpaces && typeof value === 'string') {
        value = value.trim().replace(/\s{2,}/g, ' ');
    }
    if (component.allowMultipleMasks && component.inputMasks && component.inputMasks.length > 0) {
        if (Array.isArray(value)) {
            return value.map((val) => normalizeMaskValue(component, defaultValues, val, path));
        }
        else {
            return normalizeMaskValue(component, defaultValues, value, path);
        }
    }
    return value;
};
// Allow submissions of time components in their visual "format" property by coercing them to the "dataFormat" property
// i.e. "HH:mm" -> "HH:mm:ss"
const normalizeTimeComponentValue = (component, value) => {
    const defaultDataFormat = 'HH:mm:ss';
    const defaultFormat = 'HH:mm';
    if ((0, dayjs_1.default)(value, component.format || defaultFormat, true).isValid()) {
        return (0, dayjs_1.default)(value, component.format || defaultFormat, true).format(component.dataFormat || defaultDataFormat);
    }
    return value;
};
const normalizeProcess = (context) => __awaiter(void 0, void 0, void 0, function* () {
    return (0, exports.normalizeProcessSync)(context);
});
exports.normalizeProcess = normalizeProcess;
const normalizeProcessSync = (context) => {
    const { component, form, scope, path, data, value } = context;
    if (!scope.normalize) {
        scope.normalize = {};
    }
    let { defaultValues } = scope;
    scope.normalize[path] = {
        type: component.type,
        normalized: false
    };
    // First check for component-type-specific transformations
    if (isAddressComponent(component)) {
        (0, set_1.default)(data, path, normalizeAddressComponentValue(component, value));
        scope.normalize[path].normalized = true;
    }
    else if (isDayComponent(component)) {
        (0, set_1.default)(data, path, normalizeDayComponentValue(component, form, value));
        scope.normalize[path].normalized = true;
    }
    else if (isEmailComponent(component)) {
        if (value && typeof value === 'string') {
            (0, set_1.default)(data, path, value.toLowerCase());
            scope.normalize[path].normalized = true;
        }
    }
    else if (isRadioComponent(component)) {
        (0, set_1.default)(data, path, normalizeRadioComponentValue(value));
        scope.normalize[path].normalized = true;
    }
    else if (isSelectComponent(component)) {
        (0, set_1.default)(data, path, normalizeSelectComponentValue(component, value));
        scope.normalize[path].normalized = true;
    }
    else if (isSelectBoxesComponent(component)) {
        (0, set_1.default)(data, path, normalizeSelectBoxesComponentValue(value));
        scope.normalize[path].normalized = true;
    }
    else if (isTagsComponent(component)) {
        (0, set_1.default)(data, path, normalizeTagsComponentValue(component, value));
        scope.normalize[path].normalized = true;
    }
    else if (isTextFieldComponent(component)) {
        (0, set_1.default)(data, path, normalizeTextFieldComponentValue(component, defaultValues, value, path));
        scope.normalize[path].normalized = true;
    }
    else if (isTimeComponent(component)) {
        (0, set_1.default)(data, path, normalizeTimeComponentValue(component, value));
        scope.normalize[path].normalized = true;
    }
    // Next perform component-type-agnostic transformations (i.e. super())
    if (component.multiple && !Array.isArray(value)) {
        (0, set_1.default)(data, path, value ? [value] : []);
        scope.normalize[path].normalized = true;
    }
};
exports.normalizeProcessSync = normalizeProcessSync;
exports.normalizeProcessInfo = {
    name: 'normalize',
    shouldProcess: () => true,
    process: exports.normalizeProcess,
    processSync: exports.normalizeProcessSync
};
