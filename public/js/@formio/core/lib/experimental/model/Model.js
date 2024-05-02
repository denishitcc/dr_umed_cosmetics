"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
exports.Model = void 0;
const lodash_1 = require("lodash");
const EventEmitter_1 = require("./EventEmitter");
function Model(props = {}) {
    if (!props.schema) {
        props.schema = {};
    }
    if (!props.schema.key) {
        props.schema.key = '';
    }
    return function (BaseClass) {
        return class BaseModel extends (0, EventEmitter_1.EventEmitter)(BaseClass) {
            /**
             * The default JSON schema
             * @param extend
             */
            static schema() {
                return props.schema;
            }
            /**
             * @constructor
             * @param component
             * @param options
             * @param data
             */
            constructor(component = {}, options = {}, data = {}) {
                super(component, options, data);
                this.component = component;
                this.options = options;
                this.data = data;
                /**
                 * The root entity.
                 */
                this.root = null;
                this.id = `e${Math.random().toString(36).substring(7)}`;
                this.component = (0, lodash_1.merge)({}, this.defaultSchema, this.component);
                this.options = Object.assign(Object.assign({}, this.defaultOptions), this.options);
                if (!this.options.noInit) {
                    this.init();
                }
            }
            get defaultOptions() {
                return {};
            }
            get defaultSchema() {
                return BaseModel.schema();
            }
            /**
             * Initializes the entity.
             */
            init() {
                this.hook('init');
            }
            /**
             * Return the errors from validation for this component.
             */
            get errors() {
                return this.validator.errors;
            }
            /**
             * The empty value for this component.
             *
             * @return {null}
             */
            get emptyValue() {
                return null;
            }
            /**
             * Checks to see if this components value is empty.
             *
             * @param value
             * @returns
             */
            isEmpty(value = this.dataValue) {
                const isEmptyArray = ((0, lodash_1.isArray)(value) && value.length === 1) ? (0, lodash_1.isEqual)(value[0], this.emptyValue) : false;
                return value == null || value.length === 0 || (0, lodash_1.isEqual)(value, this.emptyValue) || isEmptyArray;
            }
            /**
             * Returns the data value for this component.
             */
            get dataValue() {
                return this.component.key ? (0, lodash_1.get)(this.data, this.component.key) : this.data;
            }
            /**
             * Sets the datavalue for this component.
             */
            set dataValue(value) {
                if (this.component.key) {
                    (0, lodash_1.set)(this.data, this.component.key, value);
                }
            }
            /**
             * Determine if this component has changed values.
             *
             * @param value - The value to compare against the current value.
             */
            hasChanged(value) {
                return String(value) !== String(this.dataValue);
            }
            /**
             * Updates the data model value
             * @param value The value to update within this component.
             * @return boolean true if the value has changed.
             */
            updateValue(value) {
                const changed = this.hasChanged(value);
                this.dataValue = value;
                if (changed) {
                    // Bubble a change event.
                    this.bubble('change', value);
                }
                return changed;
            }
            /**
             * Get the model value.
             * @returns
             */
            getValue() {
                return this.dataValue;
            }
            /**
             * Allow for options to hook into the functionality of this entity.
             * @return {*}
             */
            hook(name, ...args) {
                if (this.options &&
                    this.options.hooks &&
                    this.options.hooks[name]) {
                    return this.options.hooks[name].apply(this, args);
                }
                else {
                    // If this is an async hook instead of a sync.
                    const fn = (typeof args[args.length - 1] === 'function') ? args[args.length - 1] : null;
                    if (fn) {
                        return fn(null, args[1]);
                    }
                    else {
                        return args[1];
                    }
                }
            }
        };
    };
}
exports.Model = Model;
