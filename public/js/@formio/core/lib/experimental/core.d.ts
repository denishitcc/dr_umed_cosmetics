import 'core-js/features/object/from-entries';
import { Formio } from '../sdk';
import { Evaluator, Utils } from '../utils';
import { Components, render } from './base';
import { Template } from './template';
export default class FormioCore extends Formio {
    static Components: typeof Components;
    static render: typeof render;
    static Evaluator: typeof Evaluator;
    static Utils: typeof Utils;
    static Templates: typeof Template;
    static usePlugin(key: string, plugin: any): void;
    static useModule(module: any): void;
    /**
     * Allows passing in plugins as multiple arguments or an array of plugins.
     *
     * Formio.plugins(plugin1, plugin2, etc);
     * Formio.plugins([plugin1, plugin2, etc]);
     */
    static use(...mods: any): void;
}
