"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
exports.ProcessorError = void 0;
class ProcessorError extends Error {
    constructor(message, context, processor = 'unknown') {
        super(message);
        this.message = `${message}\nin ${processor} at ${context.path}`;
        const { component, path, data, row } = context;
        this.context = { component, path, data, row };
    }
}
exports.ProcessorError = ProcessorError;
;
