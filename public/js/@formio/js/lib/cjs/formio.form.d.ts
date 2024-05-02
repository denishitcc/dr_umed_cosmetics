/**
 * Register a module
 * @param {*} plugin
 * @returns
 */
export function registerModule(mod: any, defaultFn?: null, options?: {}): void;
export function useModule(defaultFn?: null): (plugins: any, options?: {}) => void;
export { Formio as FormioCore } from "./Formio";
import Components from './components/Components';
import Displays from './displays/Displays';
import Providers from './providers';
import Widgets from './widgets';
import Templates from './templates/Templates';
import Utils from './utils';
import Form from './Form';
import { Formio } from './Formio';
import Licenses from './licenses';
import EventEmitter from './EventEmitter';
import Webform from './Webform';
export { Components, Displays, Providers, Widgets, Templates, Utils, Form, Formio, Licenses, EventEmitter, Webform };
