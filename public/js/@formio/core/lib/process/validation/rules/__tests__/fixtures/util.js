"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
exports.generateProcessorContext = void 0;
const lodash_1 = require("lodash");
const types_1 = require("../../../../../types");
const generateProcessorContext = (component, data, form) => {
    const path = component.key;
    const value = (0, lodash_1.get)(data, path);
    return {
        component,
        data,
        form,
        scope: { errors: [] },
        row: data,
        path: component.key,
        value,
        config: {
            server: true
        },
        fetch: (url, options) => {
            return Promise.resolve({
                ok: true,
                json: () => Promise.resolve([]),
                text: () => Promise.resolve('')
            });
        },
        processor: types_1.ProcessorType.Validate
    };
};
exports.generateProcessorContext = generateProcessorContext;
