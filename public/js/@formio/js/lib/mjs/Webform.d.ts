/**
 * Represents a JSON value.
 * @typedef {(string | number | boolean | null | JSONArray | JSONObject)} JSON
 */
/**
 * Represents a JSON array.
 * @typedef {Array<JSON>} JSONArray
 */
/**
 * Represents a JSON object.
 * @typedef {{[key: string]: JSON}} JSONObject
 */
/**
 * @typedef {Object} FormioHooks
 * @property {function} [beforeSubmit]
 * @property {function} [beforeCancel]
 * @property {function} [beforeNext]
 * @property {function} [beforePrev]
 * @property {function} [attachComponent]
 * @property {function} [setDataValue]
 * @property {function} [addComponents]
 * @property {function} [addComponent]
 * @property {function} [customValidation]
 * @property {function} [attachWebform]
 */
/**
 * @typedef {Object} SanitizeConfig
 * @property {string[]} [addAttr]
 * @property {string[]} [addTags]
 * @property {string[]} [allowedAttrs]
 * @property {string[]} [allowedTags]
 * @property {string[]} [allowedUriRegex]
 * @property {string[]} [addUriSafeAttr]
 */
/**
 * @typedef {Object} ButtonSettings
 * @property {boolean} [showPrevious]
 * @property {boolean} [showNext]
 * @property {boolean} [showCancel]
 * @property {boolean} [showSubmit]
 */
/**
 * @typedef {Object} FormOptions
 * @property {boolean} [saveDraft] - Enable the save draft feature.
 * @property {number} [saveDraftThrottle] - The throttle for the save draft feature.
 * @property {boolean} [readOnly] - Set this form to readOnly.
 * @property {boolean} [noAlerts] - Disable the alerts dialog.
 * @property {{[key: string]: string}} [i18n] - The translation file for this rendering.
 * @property {string} [template] - Custom logic for creation of elements.
 * @property {boolean} [noDefaults] - Exclude default values from the settings.
 * @property {any} [fileService] - The file service for this form.
 * @property {EventEmitter} [events] - The EventEmitter for this form.
 * @property {string} [language] - The language to render this form in.
 * @property {{[key: string]: string}} [i18next] - The i18next configuration for this form.
 * @property {boolean} [viewAsHtml] - View the form as raw HTML.
 * @property {'form' | 'html' | 'flat' | 'builder' | 'pdf'} [renderMode] - The render mode for this form.
 * @property {boolean} [highlightErrors] - Highlight any errors on the form.
 * @property {string} [componentErrorClass] - The error class for components.
 * @property {any} [templates] - The templates for this form.
 * @property {string} [iconset] - The iconset for this form.
 * @property {Component[]} [components] - The components for this form.
 * @property {{[key: string]: boolean}} [disabled] - Disabled components for this form.
 * @property {boolean} [showHiddenFields] - Show hidden fields.
 * @property {{[key: string]: boolean}} [hide] - Hidden components for this form.
 * @property {{[key: string]: boolean}} [show] - Components to show for this form.
 * @property {Formio} [formio] - The Formio instance for this form.
 * @property {string} [decimalSeparator] - The decimal separator for this form.
 * @property {string} [thousandsSeparator] - The thousands separator for this form.
 * @property {FormioHooks} [hooks] - The hooks for this form.
 * @property {boolean} [alwaysDirty] - Always be dirty.
 * @property {boolean} [skipDraftRestore] - Skip restoring a draft.
 * @property {'form' | 'wizard' | 'pdf'} [display] - The display for this form.
 * @property {string} [cdnUrl] - The CDN url for this form.
 * @property {boolean} [flatten] - Flatten the form.
 * @property {boolean} [sanitize] - Sanitize the form.
 * @property {SanitizeConfig} [sanitizeConfig] - The sanitize configuration for this form.
 * @property {ButtonSettings} [buttonSettings] - The button settings for this form.
 * @property {Object} [breadCrumbSettings] - The breadcrumb settings for this form.
 * @property {boolean} [allowPrevious] - Allow the previous button (for Wizard forms).
 * @property {string[]} [wizardButtonOrder] - The order of the buttons (for Wizard forms).
 * @property {boolean} [showCheckboxBackground] - Show the checkbox background.
 * @property {boolean} [inputsOnly] - Only show inputs in the form and no labels.
 * @property {boolean} [building] - If we are in the process of building the form.
 * @property {number} [zoom] - The zoom for PDF forms.
 */
/**
 * Renders a Form.io form within the webpage.
 */
declare class Webform extends NestedDataComponent {
    /**
     * Creates a new Form instance.
     *
     * @param {HTMLElement | Object | FormOptions} [elementOrOptions] - The DOM element to render this form within or the options to create this form instance.
     * @param {FormOptions} [options] - The options to create a new form instance.
     */
    constructor(elementOrOptions?: HTMLElement | Object | FormOptions, options?: FormOptions | undefined);
    /**
     * @type {FormOptions} - the options for this Webform.
     */
    options: FormOptions;
    _src: string;
    _loading: boolean;
    _form: {};
    draftEnabled: boolean;
    savingDraft: boolean;
    triggerSaveDraft: any;
    set nosubmit(value: any);
    get nosubmit(): any;
    /**
     * Determines if the form has tried to be submitted, error or not.
     *
     * @type {boolean}
     */
    submitted: boolean;
    /**
     * Determines if the form is being submitted at the moment.
     *
     * @type {boolean}
     */
    submitting: boolean;
    /**
     * The Formio instance for this form.
     * @type {Formio}
     */
    formio: Formio;
    /**
     * The loader HTML element.
     * @type {HTMLElement}
     */
    loader: HTMLElement;
    /**
     * The alert HTML element
     * @type {HTMLElement}
     */
    alert: HTMLElement;
    /**
     * Promise that is triggered when the submission is done loading.
     * @type {Promise}
     */
    onSubmission: Promise<any>;
    /**
     * Determines if this submission is explicitly set.
     * @type {boolean}
     */
    submissionSet: boolean;
    /**
     * Promise that executes when the form is ready and rendered.
     * @type {Promise}
     *
     * @example
     * import Webform from '@formio/js/Webform';
     * let form = new Webform(document.getElementById('formio'));
     * form.formReady.then(() => {
     *   console.log('The form is ready!');
     * });
     * form.src = 'https://examples.form.io/example';
     */
    formReady: Promise<any>;
    /**
     * Called when the formReady state of this form has been resolved.
     *
     * @type {function}
     */
    formReadyResolve: Function;
    /**
     * Called when this form could not load and is rejected.
     *
     * @type {function}
     */
    formReadyReject: Function;
    /**
     * Promise that executes when the submission is ready and rendered.
     * @type {Promise}
     *
     * @example
     * import Webform from '@formio/js/Webform';
     * let form = new Webform(document.getElementById('formio'));
     * form.submissionReady.then(() => {
     *   console.log('The submission is ready!');
     * });
     * form.src = 'https://examples.form.io/example/submission/234234234234234243';
     */
    submissionReady: Promise<any>;
    /**
     * Called when the formReady state of this form has been resolved.
     *
     * @type {function}
     */
    submissionReadyResolve: Function;
    /**
     * Called when this form could not load and is rejected.
     *
     * @type {function}
     */
    submissionReadyReject: Function;
    shortcuts: any[];
    /**
     * Sets the language for this form.
     *
     * @param lang
     * @return {Promise}
     */
    set language(lang: string | undefined);
    get language(): string | undefined;
    root: this;
    localRoot: this;
    get emptyValue(): null;
    get shadowRoot(): any;
    /**
     * Add a language for translations
     *
     * @param code
     * @param lang
     * @param active
     * @return {*}
     */
    addLanguage(code: any, lang: any, active?: boolean): any;
    keyboardCatchableElement(element: any): boolean;
    executeShortcuts: (event: any) => void;
    /**
     * Set the Form source, which is typically the Form.io embed URL.
     *
     * @param {string} value - The value of the form embed url.
     *
     * @example
     * import Webform from '@formio/js/Webform';
     * let form = new Webform(document.getElementById('formio'));
     * form.formReady.then(() => {
     *   console.log('The form is formReady!');
     * });
     * form.src = 'https://examples.form.io/example';
     */
    set src(value: string);
    /**
     * Get the embed source of the form.
     *
     * @returns {string}
     */
    get src(): string;
    /**
     * Loads the submission if applicable.
     */
    loadSubmission(): Promise<any>;
    loadingSubmission: boolean | undefined;
    /**
     * Set the src of the form renderer.
     *
     * @param value
     * @param options
     */
    setSrc(value: any, options: any): any;
    /**
     * Set the form source but don't initialize the form and submission from the url.
     *
     * @param {string} value - The value of the form embed url.
     */
    set url(value: string);
    /**
     * Get the embed source of the form.
     *
     * @returns {string}
     */
    get url(): string;
    /**
     * Sets the url of the form renderer.
     *
     * @param value
     * @param options
     */
    setUrl(value: any, options: any): boolean;
    /**
     * Called when both the form and submission have been loaded.
     *
     * @returns {Promise} - The promise to trigger when both form and submission have loaded.
     */
    get ready(): Promise<any>;
    /**
     * Set the loading state for this form, and also show the loader spinner.
     *
     * @param {boolean} loading - If this form should be "loading" or not.
     */
    set loading(loading: boolean);
    /**
     * Returns if this form is loading.
     *
     * @returns {boolean} - TRUE means the form is loading, FALSE otherwise.
     */
    get loading(): boolean;
    /**
     * Sets the JSON schema for the form to be rendered.
     *
     * @example
     * import Webform from '@formio/js/Webform';
     * let form = new Webform(document.getElementById('formio'));
     * form.setForm({
     *   components: [
     *     {
     *       type: 'textfield',
     *       key: 'firstName',
     *       label: 'First Name',
     *       placeholder: 'Enter your first name.',
     *       input: true
     *     },
     *     {
     *       type: 'textfield',
     *       key: 'lastName',
     *       label: 'Last Name',
     *       placeholder: 'Enter your last name',
     *       input: true
     *     },
     *     {
     *       type: 'button',
     *       action: 'submit',
     *       label: 'Submit',
     *       theme: 'primary'
     *     }
     *   ]
     * });
     *
     * @param {Object} form - The JSON schema of the form @see https://examples.form.io/example for an example JSON schema.
     * @param flags
     * @returns {*}
     */
    setForm(form: Object, flags: any): any;
    initialized: boolean | undefined;
    /**
     * Sets the form value.
     *
     * @alias setForm
     * @param {Object} form - The form schema object.
     */
    set form(form: Object);
    /**
     * Gets the form object.
     *
     * @returns {Object} - The form JSON schema.
     */
    get form(): Object;
    /**
     * Sets the submission of a form.
     *
     * @example
     * import Webform from '@formio/js/Webform';
     * let form = new Webform(document.getElementById('formio'));
     * form.src = 'https://examples.form.io/example';
     * form.submission = {data: {
     *   firstName: 'Joe',
     *   lastName: 'Smith',
     *   email: 'joe@example.com'
     * }};
     *
     * @param {Object} submission - The Form.io submission object.
     */
    set submission(submission: Object);
    /**
     * Returns the submission object that was set within this form.
     *
     * @returns {Object}
     */
    get submission(): Object;
    /**
     * Sets a submission and returns the promise when it is ready.
     * @param submission
     * @param flags
     * @return {Promise.<TResult>}
     */
    setSubmission(submission: any, flags?: {}): Promise<TResult>;
    handleDraftError(errName: any, errDetails: any, restoreDraft: any): void;
    /**
     * Saves a submission draft.
     */
    saveDraft(): void;
    /**
     * Restores a draft submission based on the user who is authenticated.
     *
     * @param {userId} - The user id where we need to restore the draft from.
     */
    restoreDraft(userId: any): void;
    mergeData(_this: any, _that: any): void;
    editing: boolean | undefined;
    _submission: any;
    /**
     * Build the form.
     */
    init(): Promise<any>;
    executeFormController(): false | undefined;
    build(element: any): Promise<any>;
    getClassName(): string;
    render(): any;
    redraw(): Promise<void> | Promise<boolean>;
    attach(element: any): Promise<boolean>;
    hasRequiredFields(): boolean;
    /**
     * Sets a new alert to display in the error dialog of the form.
     *
     * @param {string} type - The type of alert to display. "danger", "success", "warning", etc.
     * @param {string} message - The message to show in the alert.
     * @param {Object} options
     */
    setAlert(type: string, message: string, options: Object): void;
    /**
     * Focus on selected component.
     *
     * @param {string} key - The key of selected component.
     * @returns {*}
     */
    focusOnComponent(key: string): any;
    /**
     * Show the errors of this form within the alert dialog.
     *
     * @param {Object} error - An optional additional error to display along with the component errors.
     * @returns {*}
     */
    showErrors(errors: any, triggerEvent: any): any;
    /**
     * Called when the submission has completed, or if the submission needs to be sent to an external library.
     *
     * @param {Object} submission - The submission object.
     * @param {boolean} saved - Whether or not this submission was saved to the server.
     * @returns {object} - The submission object.
     */
    onSubmit(submission: Object, saved: boolean): object;
    normalizeError(error: any): any;
    /**
     * Called when an error occurs during the submission.
     *
     * @param {Object} error - The error that occured.
     */
    onSubmissionError(error: Object): any;
    /**
     * Trigger the change event for this form.
     *
     * @param changed
     * @param flags
     */
    onChange(flags: any, changed: any, modified: any, changes: any): void;
    /**
     * Send a delete request to the server.
     */
    deleteSubmission(): any;
    /**
     * Cancels the submission.
     *
     * @alias reset
     */
    cancel(noconfirm: any): boolean;
    setMetadata(submission: any): void;
    submitForm(options?: {}): Promise<any>;
    setServerErrors(error: any): void;
    serverErrors: any;
    executeSubmit(options: any): Promise<object>;
    submissionInProcess: boolean | undefined;
    clearServerErrors(): void;
    /**
     * Submits the form.
     *
     * @example
     * import Webform from '@formio/js/Webform';
     * let form = new Webform(document.getElementById('formio'));
     * form.src = 'https://examples.form.io/example';
     * form.submission = {data: {
     *   firstName: 'Joe',
     *   lastName: 'Smith',
     *   email: 'joe@example.com'
     * }};
     * form.submit().then((submission) => {
     *   console.log(submission);
     * });
     *
     * @param {boolean} before - If this submission occured from the before handlers.
     *
     * @returns {Promise} - A promise when the form is done submitting.
     */
    submit(before?: boolean, options?: {}): Promise<any>;
    submitUrl(URL: any, headers: any): void;
    triggerRecaptcha(): void;
    _nosubmit: any;
    get conditions(): any;
    get variables(): any;
}
declare namespace Webform {
    let setBaseUrl: any;
    let setApiUrl: any;
    let setAppUrl: any;
}
export default Webform;
/**
 * Represents a JSON value.
 */
export type JSON = (string | number | boolean | null | JSON[] | JSONObject);
/**
 * Represents a JSON array.
 */
export type JSONArray = Array<JSON>;
/**
 * Represents a JSON object.
 */
export type JSONObject = {
    [key: string]: JSON;
};
export type FormioHooks = {
    beforeSubmit?: Function | undefined;
    beforeCancel?: Function | undefined;
    beforeNext?: Function | undefined;
    beforePrev?: Function | undefined;
    attachComponent?: Function | undefined;
    setDataValue?: Function | undefined;
    addComponents?: Function | undefined;
    addComponent?: Function | undefined;
    customValidation?: Function | undefined;
    attachWebform?: Function | undefined;
};
export type SanitizeConfig = {
    addAttr?: string[] | undefined;
    addTags?: string[] | undefined;
    allowedAttrs?: string[] | undefined;
    allowedTags?: string[] | undefined;
    allowedUriRegex?: string[] | undefined;
    addUriSafeAttr?: string[] | undefined;
};
export type ButtonSettings = {
    showPrevious?: boolean | undefined;
    showNext?: boolean | undefined;
    showCancel?: boolean | undefined;
    showSubmit?: boolean | undefined;
};
export type FormOptions = {
    /**
     * - Enable the save draft feature.
     */
    saveDraft?: boolean | undefined;
    /**
     * - The throttle for the save draft feature.
     */
    saveDraftThrottle?: number | undefined;
    /**
     * - Set this form to readOnly.
     */
    readOnly?: boolean | undefined;
    /**
     * - Disable the alerts dialog.
     */
    noAlerts?: boolean | undefined;
    /**
     * - The translation file for this rendering.
     */
    i18n?: {
        [key: string]: string;
    } | undefined;
    /**
     * - Custom logic for creation of elements.
     */
    template?: string | undefined;
    /**
     * - Exclude default values from the settings.
     */
    noDefaults?: boolean | undefined;
    /**
     * - The file service for this form.
     */
    fileService?: any;
    /**
     * - The EventEmitter for this form.
     */
    events?: EventEmitter | undefined;
    /**
     * - The language to render this form in.
     */
    language?: string | undefined;
    /**
     * - The i18next configuration for this form.
     */
    i18next?: {
        [key: string]: string;
    } | undefined;
    /**
     * - View the form as raw HTML.
     */
    viewAsHtml?: boolean | undefined;
    /**
     * - The render mode for this form.
     */
    renderMode?: "flat" | "builder" | "form" | "html" | "pdf" | undefined;
    /**
     * - Highlight any errors on the form.
     */
    highlightErrors?: boolean | undefined;
    /**
     * - The error class for components.
     */
    componentErrorClass?: string | undefined;
    /**
     * - The templates for this form.
     */
    templates?: any;
    /**
     * - The iconset for this form.
     */
    iconset?: string | undefined;
    /**
     * - The components for this form.
     */
    components?: Component[] | undefined;
    /**
     * - Disabled components for this form.
     */
    disabled?: {
        [key: string]: boolean;
    } | undefined;
    /**
     * - Show hidden fields.
     */
    showHiddenFields?: boolean | undefined;
    /**
     * - Hidden components for this form.
     */
    hide?: {
        [key: string]: boolean;
    } | undefined;
    /**
     * - Components to show for this form.
     */
    show?: {
        [key: string]: boolean;
    } | undefined;
    /**
     * - The Formio instance for this form.
     */
    formio?: any;
    /**
     * - The decimal separator for this form.
     */
    decimalSeparator?: string | undefined;
    /**
     * - The thousands separator for this form.
     */
    thousandsSeparator?: string | undefined;
    /**
     * - The hooks for this form.
     */
    hooks?: FormioHooks | undefined;
    /**
     * - Always be dirty.
     */
    alwaysDirty?: boolean | undefined;
    /**
     * - Skip restoring a draft.
     */
    skipDraftRestore?: boolean | undefined;
    /**
     * - The display for this form.
     */
    display?: "wizard" | "form" | "pdf" | undefined;
    /**
     * - The CDN url for this form.
     */
    cdnUrl?: string | undefined;
    /**
     * - Flatten the form.
     */
    flatten?: boolean | undefined;
    /**
     * - Sanitize the form.
     */
    sanitize?: boolean | undefined;
    /**
     * - The sanitize configuration for this form.
     */
    sanitizeConfig?: SanitizeConfig | undefined;
    /**
     * - The button settings for this form.
     */
    buttonSettings?: ButtonSettings | undefined;
    /**
     * - The breadcrumb settings for this form.
     */
    breadCrumbSettings?: Object | undefined;
    /**
     * - Allow the previous button (for Wizard forms).
     */
    allowPrevious?: boolean | undefined;
    /**
     * - The order of the buttons (for Wizard forms).
     */
    wizardButtonOrder?: string[] | undefined;
    /**
     * - Show the checkbox background.
     */
    showCheckboxBackground?: boolean | undefined;
    /**
     * - Only show inputs in the form and no labels.
     */
    inputsOnly?: boolean | undefined;
    /**
     * - If we are in the process of building the form.
     */
    building?: boolean | undefined;
    /**
     * - The zoom for PDF forms.
     */
    zoom?: number | undefined;
};
import NestedDataComponent from './components/_classes/nesteddata/NestedDataComponent';
import EventEmitter from './EventEmitter';
import { Component } from '@formio/core';
