"use strict";
var __importDefault = (this && this.__importDefault) || function (mod) {
    return (mod && mod.__esModule) ? mod : { "default": mod };
};
Object.defineProperty(exports, "__esModule", { value: true });
require("core-js/features/object/from-entries");
const sdk_1 = require("../sdk");
const utils_1 = require("../utils");
const base_1 = require("./base");
const template_1 = require("./template");
const lodash_1 = require("lodash");
const components_1 = __importDefault(require("./components"));
const modules_1 = __importDefault(require("../modules"));
class FormioCore extends sdk_1.Formio {
    static usePlugin(key, plugin) {
        switch (key) {
            case 'options':
                if (!sdk_1.Formio.options) {
                    return;
                }
                sdk_1.Formio.options = (0, lodash_1.merge)(sdk_1.Formio.options, plugin);
                break;
            case 'templates':
                if (!sdk_1.Formio.Templates) {
                    return;
                }
                const current = sdk_1.Formio.Templates.framework || 'bootstrap';
                for (const framework of Object.keys(plugin)) {
                    sdk_1.Formio.Templates.extendTemplate(framework, plugin[framework]);
                }
                if (plugin[current]) {
                    sdk_1.Formio.Templates.current = plugin[current];
                }
                break;
            case 'components':
                if (!sdk_1.Formio.Components) {
                    return;
                }
                sdk_1.Formio.Components.setComponents(plugin);
                break;
            case 'framework':
                if (!sdk_1.Formio.Templates) {
                    return;
                }
                sdk_1.Formio.Templates.framework = plugin;
                break;
            case 'fetch':
                for (const name of Object.keys(plugin)) {
                    sdk_1.Formio.registerPlugin(plugin[name], name);
                }
                break;
            case 'rules':
                if (!sdk_1.Formio.Rules) {
                    return;
                }
                sdk_1.Formio.Rules.addRules(plugin);
                break;
            case 'evaluator':
                if (!sdk_1.Formio.Evaluator) {
                    return;
                }
                sdk_1.Formio.Evaluator.registerEvaluator(plugin);
                break;
            default:
                console.log('Unknown plugin option', key);
        }
    }
    static useModule(module) {
        // Sanity check.
        if (typeof module !== 'object') {
            return;
        }
        for (const key of Object.keys(module)) {
            FormioCore.usePlugin(key, module[key]);
        }
    }
    /**
     * Allows passing in plugins as multiple arguments or an array of plugins.
     *
     * Formio.plugins(plugin1, plugin2, etc);
     * Formio.plugins([plugin1, plugin2, etc]);
     */
    static use(...mods) {
        mods.forEach((mod) => {
            if (Array.isArray(mod)) {
                mod.forEach(p => FormioCore.useModule(p));
            }
            else {
                FormioCore.useModule(mod);
            }
        });
    }
}
FormioCore.Components = base_1.Components;
FormioCore.render = base_1.render;
FormioCore.Evaluator = utils_1.Evaluator;
FormioCore.Utils = utils_1.Utils;
FormioCore.Templates = template_1.Template;
exports.default = FormioCore;
FormioCore.use(components_1.default);
FormioCore.use(modules_1.default);
