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
exports.fetchProcessInfo = exports.fetchProcess = exports.shouldFetch = void 0;
const get_1 = __importDefault(require("lodash/get"));
const set_1 = __importDefault(require("lodash/set"));
const utils_1 = require("../../utils");
const formUtil_1 = require("../../utils/formUtil");
const shouldFetch = (context) => {
    const { component, config } = context;
    if (component.type !== 'datasource' ||
        ((config === null || config === void 0 ? void 0 : config.server) && !(0, get_1.default)(component, 'trigger.server', false))) {
        return false;
    }
    return true;
};
exports.shouldFetch = shouldFetch;
const fetchProcess = (context) => __awaiter(void 0, void 0, void 0, function* () {
    var _a;
    const { component, row, evalContext, path, scope, config } = context;
    let _fetch = null;
    try {
        _fetch = context.fetch ? context.fetch : fetch;
    }
    catch (err) {
        _fetch = null;
    }
    if (!_fetch) {
        console.log('You must provide a fetch interface to the fetch processor.');
        return;
    }
    if (!(0, exports.shouldFetch)(context)) {
        return;
    }
    if (!scope.fetched)
        scope.fetched = {};
    const evalContextValue = evalContext ? evalContext(context) : context;
    const url = utils_1.Evaluator.interpolateString((0, get_1.default)(component, 'fetch.url', ''), evalContextValue);
    if (!url) {
        return;
    }
    const request = {
        method: (0, get_1.default)(component, 'fetch.method', 'get').toUpperCase(),
        headers: {}
    };
    if ((config === null || config === void 0 ? void 0 : config.headers) &&
        (component === null || component === void 0 ? void 0 : component.fetch) &&
        ((_a = component === null || component === void 0 ? void 0 : component.fetch) === null || _a === void 0 ? void 0 : _a.forwardHeaders)) {
        request.headers = JSON.parse(JSON.stringify(config.headers));
        delete request.headers['host'];
        delete request.headers['content-length'];
        delete request.headers['content-type'];
        delete request.headers['connection'];
        delete request.headers['cache-control'];
    }
    request.headers['Accept'] = '*/*';
    request.headers['user-agent'] = 'Form.io DataSource Component';
    (0, get_1.default)(component, 'fetch.headers', []).map((header) => {
        header.value = utils_1.Evaluator.interpolateString(header.value, evalContextValue);
        if (header.value && header.key) {
            request.headers[header.key] = header.value;
        }
        return header;
    });
    if ((0, get_1.default)(component, 'fetch.authenticate', false) && (config === null || config === void 0 ? void 0 : config.tokens)) {
        Object.assign(request.headers, config.tokens);
    }
    const body = (0, get_1.default)(component, 'fetch.specifyBody', '');
    if (request.method === 'POST') {
        request.body = JSON.stringify(utils_1.Evaluator.evaluate(body, evalContextValue, 'body'));
    }
    try {
        // Perform the fetch.
        const result = yield (yield _fetch(url, request)).json();
        const mapFunction = (0, get_1.default)(component, 'fetch.mapFunction');
        // Set the row data of the fetched value.
        const key = (0, formUtil_1.getComponentKey)(component);
        (0, set_1.default)(row, key, mapFunction ? utils_1.Evaluator.evaluate(mapFunction, Object.assign(Object.assign({}, evalContextValue), { responseData: result }), 'value') : result);
        // Make sure the value does not get filtered for now...
        if (!scope.filter)
            scope.filter = {};
        scope.filter[path] = true;
        scope.fetched[path] = true;
    }
    catch (err) {
        console.log(err.message);
    }
});
exports.fetchProcess = fetchProcess;
exports.fetchProcessInfo = {
    name: 'fetch',
    process: exports.fetchProcess,
    shouldProcess: exports.shouldFetch,
};
