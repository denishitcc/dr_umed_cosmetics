"use strict";
var __importDefault = (this && this.__importDefault) || function (mod) {
    return (mod && mod.__esModule) ? mod : { "default": mod };
};
Object.defineProperty(exports, "__esModule", { value: true });
const Component_1 = __importDefault(require("./_classes/component/Component"));
const utils_1 = __importDefault(require("./_classes/component/editForm/utils"));
const Component_form_1 = __importDefault(require("./_classes/component/Component.form"));
const lodash_1 = __importDefault(require("lodash"));
class Components {
    static set EditFormUtils(value) {
        Components._editFormUtils = value;
    }
    static get EditFormUtils() {
        return Components._editFormUtils;
    }
    static set baseEditForm(value) {
        Components._baseEditForm = value;
    }
    static get baseEditForm() {
        return Components._baseEditForm;
    }
    static recalculateComponents() {
        if (window && window.Formio && window.Formio.AllComponents) {
            Components.setComponents(window.Formio.AllComponents);
        }
    }
    static get components() {
        if (!Components._components) {
            Components._components = {};
        }
        return Components._components;
    }
    static setComponents(comps) {
        // Set the tableView method on BaseComponent.
        if (comps.base) {
            // Implement the tableView method.
            comps.base.tableView = function (value, options) {
                const comp = Components.create(options.component, options.options || {}, options.data || {}, true);
                return comp.getView(value);
            };
        }
        lodash_1.default.assign(Components.components, comps);
    }
    static addComponent(name, comp) {
        return Components.setComponent(name, comp);
    }
    static setComponent(name, comp) {
        Components.components[name] = comp;
    }
    /**
     * Return a path of component's value.
     *
     * @param {Object} component - The component instance.
     * @return {string} - The component's value path.
     */
    static getComponentPath(component) {
        var _a;
        let path = '';
        if (component.component.key) {
            let thisPath = ((_a = component.options) === null || _a === void 0 ? void 0 : _a.parent) || component;
            while (thisPath && !thisPath.allowData && thisPath.parent) {
                thisPath = thisPath.parent;
            }
            // TODO: any component that is nested in e.g. a Data Grid or an Edit Grid is going to receive a row prop; the problem
            // is that options.row is passed to each further nested component, which results in erroneous paths like
            // `editGrid[0].container[0].textField` rather than `editGrid[0].container.textField`. This should be adapted for other
            // components with a tree-like data model
            const rowIndex = component.row;
            const rowIndexPath = rowIndex && !['container'].includes(thisPath.component.type) ? `[${Number.parseInt(rowIndex)}]` : '';
            path = `${thisPath.path}${rowIndexPath}.`;
            path += component.component.key;
            return lodash_1.default.trim(path, '.');
        }
    }
    static create(component, options, data) {
        let comp = null;
        if (component.type && Components.components.hasOwnProperty(component.type)) {
            comp = new Components.components[component.type](component, options, data);
        }
        else if (component.arrayTree) {
            // eslint-disable-next-line new-cap
            comp = new Components.components['datagrid'](component, options, data);
        }
        else if (component.tree) {
            // eslint-disable-next-line new-cap
            comp = new Components.components['nesteddata'](component, options, data);
        }
        else if (Array.isArray(component.components)) {
            // eslint-disable-next-line new-cap
            comp = new Components.components['nested'](component, options, data);
        }
        else if (options && options.server) {
            // eslint-disable-next-line new-cap
            comp = new Components.components['hidden'](component, options, data);
        }
        else {
            comp = new Component_1.default(component, options, data);
        }
        const path = Components.getComponentPath(comp);
        if (path) {
            comp.path = path;
            comp.componentsMap[comp.path] = comp;
        }
        return comp;
    }
}
Components._editFormUtils = utils_1.default;
Components._baseEditForm = Component_form_1.default;
exports.default = Components;
