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
exports.dereferenceProcessInfo = exports.dereferenceProcess = void 0;
const error_1 = require("../../error");
const utils_1 = require("../../utils");
const isDereferenceableDataTableComponent = (component) => {
    var _a, _b, _c;
    return component
        && component.type === 'datatable'
        && ((_a = component.fetch) === null || _a === void 0 ? void 0 : _a.enableFetch) === true
        && ((_b = component.fetch) === null || _b === void 0 ? void 0 : _b.dataSrc) === 'resource'
        && typeof ((_c = component.fetch) === null || _c === void 0 ? void 0 : _c.resource) === 'string';
};
/**
 * This function is used to dereference reference IDs contained in the form.
 * It is currently only compatible with Data Table components.
 * @todo Add support for other components (if applicable) and for submission data dereferencing (e.g. save-as-reference, currently a property action).
 */
const dereferenceProcess = (context) => __awaiter(void 0, void 0, void 0, function* () {
    var _a;
    const { component, config, scope, path } = context;
    if (!scope.dereference) {
        scope.dereference = {};
    }
    if (!isDereferenceableDataTableComponent(component)) {
        return;
    }
    if (!(config === null || config === void 0 ? void 0 : config.database)) {
        throw new error_1.ProcessorError('Cannot dereference resource value without a database config object', context, 'dereference');
    }
    try {
        const components = yield ((_a = config.database) === null || _a === void 0 ? void 0 : _a.dereferenceDataTableComponent(component));
        const vmCompatibleComponents = (0, utils_1.fastCloneDeep)(components);
        scope.dereference[path] = vmCompatibleComponents;
        // Modify the components in place; we have to do this now as opposed to a "post-processor" step because
        // eachComponentDataAsync will immediately turn around and introspect these components in the case of Data Table
        component.components = vmCompatibleComponents;
    }
    catch (err) {
        throw new error_1.ProcessorError(err.message || err, context, 'dereference');
    }
});
exports.dereferenceProcess = dereferenceProcess;
exports.dereferenceProcessInfo = {
    name: 'dereference',
    shouldProcess: () => true,
    process: exports.dereferenceProcess,
};
