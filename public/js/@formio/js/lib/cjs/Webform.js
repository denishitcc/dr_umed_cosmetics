"use strict";
var __importDefault = (this && this.__importDefault) || function (mod) {
    return (mod && mod.__esModule) ? mod : { "default": mod };
};
Object.defineProperty(exports, "__esModule", { value: true });
const lodash_1 = __importDefault(require("lodash"));
const moment_1 = __importDefault(require("moment"));
const compare_versions_1 = require("compare-versions");
const core_1 = require("@formio/core");
const EventEmitter_1 = __importDefault(require("./EventEmitter"));
const i18n_1 = __importDefault(require("./i18n"));
const Formio_1 = require("./Formio");
const Components_1 = __importDefault(require("./components/Components"));
const NestedDataComponent_1 = __importDefault(require("./components/_classes/nesteddata/NestedDataComponent"));
const utils_1 = require("./utils/utils");
const formUtils_1 = require("./utils/formUtils");
// Initialize the available forms.
Formio_1.Formio.forms = {};
// Allow people to register components.
Formio_1.Formio.registerComponent = Components_1.default.setComponent;
function getIconSet(icons) {
    if (icons === 'fontawesome') {
        return 'fa';
    }
    return icons || '';
}
function getOptions(options) {
    options = lodash_1.default.defaults(options, {
        submitOnEnter: false,
        iconset: getIconSet((options && options.icons) ? options.icons : Formio_1.Formio.icons),
        i18next: null,
        saveDraft: false,
        alwaysDirty: false,
        saveDraftThrottle: 5000,
        display: 'form',
        cdnUrl: Formio_1.Formio.cdn.baseUrl
    });
    if (!options.events) {
        options.events = new EventEmitter_1.default();
    }
    return options;
}
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
class Webform extends NestedDataComponent_1.default {
    /**
     * Creates a new Form instance.
     *
     * @param {HTMLElement | Object | FormOptions} [elementOrOptions] - The DOM element to render this form within or the options to create this form instance.
     * @param {FormOptions} [options] - The options to create a new form instance.
     */
    constructor(elementOrOptions, options) {
        let element, formOptions;
        if (elementOrOptions instanceof HTMLElement || options) {
            element = elementOrOptions;
            formOptions = options;
        }
        else {
            formOptions = elementOrOptions;
        }
        super(null, getOptions(formOptions));
        this.executeShortcuts = (event) => {
            const { target } = event;
            if (!this.keyboardCatchableElement(target)) {
                return;
            }
            const ctrl = event.ctrlKey || event.metaKey;
            const keyCode = event.keyCode;
            let char = '';
            if (65 <= keyCode && keyCode <= 90) {
                char = String.fromCharCode(keyCode);
            }
            else if (keyCode === 13) {
                char = 'Enter';
            }
            else if (keyCode === 27) {
                char = 'Esc';
            }
            lodash_1.default.each(this.shortcuts, (shortcut) => {
                if (shortcut.ctrl && !ctrl) {
                    return;
                }
                if (shortcut.shortcut === char) {
                    shortcut.element.click();
                    event.preventDefault();
                }
            });
        };
        this.setElement(element);
        // Keep track of all available forms globally.
        Formio_1.Formio.forms[this.id] = this;
        // Set the base url.
        if (this.options.baseUrl) {
            Formio_1.Formio.setBaseUrl(this.options.baseUrl);
        }
        /**
         * The type of this element.
         * @type {string}
         */
        this.type = 'form';
        this._src = '';
        this._loading = false;
        this._form = {};
        this.draftEnabled = false;
        this.savingDraft = true;
        if (this.options.saveDraftThrottle) {
            this.triggerSaveDraft = lodash_1.default.throttle(this.saveDraft.bind(this), this.options.saveDraftThrottle);
        }
        else {
            this.triggerSaveDraft = this.saveDraft.bind(this);
        }
        /**
         * Determines if this form should submit the API on submit.
         * @type {boolean}
         */
        this.nosubmit = false;
        /**
         * Determines if the form has tried to be submitted, error or not.
         *
         * @type {boolean}
         */
        this.submitted = false;
        /**
         * Determines if the form is being submitted at the moment.
         *
         * @type {boolean}
         */
        this.submitting = false;
        /**
         * The Formio instance for this form.
         * @type {Formio}
         */
        this.formio = null;
        /**
         * The loader HTML element.
         * @type {HTMLElement}
         */
        this.loader = null;
        /**
         * The alert HTML element
         * @type {HTMLElement}
         */
        this.alert = null;
        /**
         * Promise that is triggered when the submission is done loading.
         * @type {Promise}
         */
        this.onSubmission = null;
        /**
         * Determines if this submission is explicitly set.
         * @type {boolean}
         */
        this.submissionSet = false;
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
        this.formReady = new Promise((resolve, reject) => {
            /**
             * Called when the formReady state of this form has been resolved.
             *
             * @type {function}
             */
            this.formReadyResolve = resolve;
            /**
             * Called when this form could not load and is rejected.
             *
             * @type {function}
             */
            this.formReadyReject = reject;
        });
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
        this.submissionReady = new Promise((resolve, reject) => {
            /**
             * Called when the formReady state of this form has been resolved.
             *
             * @type {function}
             */
            this.submissionReadyResolve = resolve;
            /**
             * Called when this form could not load and is rejected.
             *
             * @type {function}
             */
            this.submissionReadyReject = reject;
        });
        this.shortcuts = [];
        // Set language after everything is established.
        this.language = this.i18next.language;
        // See if we need to restore the draft from a user.
        if (this.options.saveDraft && !this.options.skipDraftRestore) {
            this.formReady.then(() => {
                const user = Formio_1.Formio.getUser();
                // Only restore a draft if the submission isn't explicitly set.
                if (user && !this.submissionSet) {
                    this.restoreDraft(user._id);
                }
            });
        }
        this.component.clearOnHide = false;
        // Ensure the root is set to this component.
        this.root = this;
        this.localRoot = this;
    }
    /* eslint-enable max-statements */
    get language() {
        return this.options.language;
    }
    get emptyValue() {
        return null;
    }
    componentContext() {
        return this._data;
    }
    /**
     * Sets the language for this form.
     *
     * @param lang
     * @return {Promise}
     */
    set language(lang) {
        if (!this.i18next) {
            return;
        }
        this.options.language = lang;
        if (this.i18next.language === lang) {
            return;
        }
        this.i18next.changeLanguage(lang, (err) => {
            if (err) {
                return;
            }
            this.rebuild();
            this.emit('languageChanged');
        });
    }
    get componentComponents() {
        return this.form.components;
    }
    get shadowRoot() {
        return this.options.shadowRoot;
    }
    /**
     * Add a language for translations
     *
     * @param code
     * @param lang
     * @param active
     * @return {*}
     */
    addLanguage(code, lang, active = false) {
        if (this.i18next) {
            var translations = lodash_1.default.assign((0, utils_1.fastCloneDeep)(i18n_1.default.resources.en.translation), lang);
            this.i18next.addResourceBundle(code, 'translation', translations, true, true);
            if (active) {
                this.language = code;
            }
        }
    }
    keyboardCatchableElement(element) {
        if (element.nodeName === 'TEXTAREA') {
            return false;
        }
        if (element.nodeName === 'INPUT') {
            return [
                'text',
                'email',
                'password'
            ].indexOf(element.type) === -1;
        }
        return true;
    }
    addShortcut(element, shortcut) {
        if (!shortcut || !/^([A-Z]|Enter|Esc)$/i.test(shortcut)) {
            return;
        }
        shortcut = lodash_1.default.capitalize(shortcut);
        if (shortcut === 'Enter' || shortcut === 'Esc') {
            // Restrict Enter and Esc only for buttons
            if (element.tagName !== 'BUTTON') {
                return;
            }
            this.shortcuts.push({
                shortcut,
                element
            });
        }
        else {
            this.shortcuts.push({
                ctrl: true,
                shortcut,
                element
            });
        }
    }
    removeShortcut(element, shortcut) {
        if (!shortcut || !/^([A-Z]|Enter|Esc)$/i.test(shortcut)) {
            return;
        }
        lodash_1.default.remove(this.shortcuts, {
            shortcut,
            element
        });
    }
    /**
     * Get the embed source of the form.
     *
     * @returns {string}
     */
    get src() {
        return this._src;
    }
    /**
     * Loads the submission if applicable.
     */
    loadSubmission() {
        this.loadingSubmission = true;
        if (this.formio.submissionId) {
            this.onSubmission = this.formio.loadSubmission().then((submission) => this.setSubmission(submission), (err) => this.submissionReadyReject(err)).catch((err) => this.submissionReadyReject(err));
        }
        else {
            this.submissionReadyResolve();
        }
        return this.submissionReady;
    }
    /**
     * Set the src of the form renderer.
     *
     * @param value
     * @param options
     */
    setSrc(value, options) {
        if (this.setUrl(value, options)) {
            this.nosubmit = false;
            return this.formio.loadForm({ params: { live: 1 } }).then((form) => {
                const setForm = this.setForm(form);
                this.loadSubmission();
                return setForm;
            }).catch((err) => {
                console.warn(err);
                this.formReadyReject(err);
            });
        }
        return Promise.resolve();
    }
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
    set src(value) {
        this.setSrc(value);
    }
    /**
     * Get the embed source of the form.
     *
     * @returns {string}
     */
    get url() {
        return this._src;
    }
    /**
     * Sets the url of the form renderer.
     *
     * @param value
     * @param options
     */
    setUrl(value, options) {
        if (!value ||
            (typeof value !== 'string') ||
            (value === this._src)) {
            return false;
        }
        this._src = value;
        this.nosubmit = true;
        this.formio = this.options.formio = new Formio_1.Formio(value, options);
        if (this.type === 'form') {
            // Set the options source so this can be passed to other components.
            this.options.src = value;
        }
        return true;
    }
    /**
     * Set the form source but don't initialize the form and submission from the url.
     *
     * @param {string} value - The value of the form embed url.
     */
    set url(value) {
        this.setUrl(value);
    }
    /**
     * Called when both the form and submission have been loaded.
     *
     * @returns {Promise} - The promise to trigger when both form and submission have loaded.
     */
    get ready() {
        return this.formReady.then(() => {
            return super.ready.then(() => {
                return this.loadingSubmission ? this.submissionReady : true;
            });
        });
    }
    /**
     * Returns if this form is loading.
     *
     * @returns {boolean} - TRUE means the form is loading, FALSE otherwise.
     */
    get loading() {
        return this._loading;
    }
    /**
     * Set the loading state for this form, and also show the loader spinner.
     *
     * @param {boolean} loading - If this form should be "loading" or not.
     */
    set loading(loading) {
        if (this._loading !== loading) {
            this._loading = loading;
            if (!this.loader && loading) {
                this.loader = this.ce('div', {
                    class: 'loader-wrapper'
                });
                const spinner = this.ce('div', {
                    class: 'loader text-center'
                });
                this.loader.appendChild(spinner);
            }
            /* eslint-disable max-depth */
            if (this.loader) {
                try {
                    if (loading) {
                        this.prependTo(this.loader, this.wrapper);
                    }
                    else {
                        this.removeChildFrom(this.loader, this.wrapper);
                    }
                }
                catch (err) {
                    // ingore
                }
            }
            /* eslint-enable max-depth */
        }
    }
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
    setForm(form, flags) {
        var _a, _b, _c;
        const isFormAlreadySet = this._form && ((_a = this._form.components) === null || _a === void 0 ? void 0 : _a.length);
        try {
            // Do not set the form again if it has been already set
            if (isFormAlreadySet && JSON.stringify(this._form) === JSON.stringify(form)) {
                return Promise.resolve();
            }
            // Create the form.
            this._form = (flags === null || flags === void 0 ? void 0 : flags.keepAsReference) ? form : lodash_1.default.cloneDeep(form);
            if (this.onSetForm) {
                this.onSetForm(lodash_1.default.cloneDeep(this._form), form);
            }
            if ((_c = (_b = this.parent) === null || _b === void 0 ? void 0 : _b.component) === null || _c === void 0 ? void 0 : _c.modalEdit) {
                return Promise.resolve();
            }
        }
        catch (err) {
            console.warn(err);
            // If provided form is not a valid JSON object, do not set it too
            return Promise.resolve();
        }
        // Allow the form to provide component overrides.
        if (form && form.settings && form.settings.components) {
            this.options.components = form.settings.components;
        }
        if (form && form.properties) {
            this.options.properties = form.properties;
        }
        // Use the sanitize config from the form settings or the global sanitize config if it is not provided in the options
        if (!this.options.sanitizeConfig && !this.builderMode) {
            this.options.sanitizeConfig = lodash_1.default.get(form, 'settings.sanitizeConfig') || lodash_1.default.get(form, 'globalSettings.sanitizeConfig');
        }
        if ('schema' in form && (0, compare_versions_1.compareVersions)(form.schema, '1.x') > 0) {
            this.ready.then(() => {
                this.setAlert('alert alert-danger', 'Form schema is for a newer version, please upgrade your renderer. Some functionality may not work.');
            });
        }
        // See if they pass a module, and evaluate it if so.
        if (form && form.module) {
            let formModule = null;
            if (typeof form.module === 'string') {
                try {
                    formModule = this.evaluate(`return ${form.module}`);
                }
                catch (err) {
                    console.warn(err);
                }
            }
            else {
                formModule = form.module;
            }
            if (formModule) {
                Formio_1.Formio.use(formModule);
                // Since we got here after instantiation, we need to manually apply form options.
                if (formModule.options && formModule.options.form) {
                    this.options = Object.assign(this.options, formModule.options.form);
                }
            }
        }
        this.initialized = false;
        const rebuild = this.rebuild() || Promise.resolve();
        return rebuild.then(() => {
            this.emit('formLoad', form);
            this.triggerRecaptcha();
            // Make sure to trigger onChange after a render event occurs to speed up form rendering.
            setTimeout(() => {
                this.onChange(flags);
                this.formReadyResolve();
            }, 0);
            return this.formReady;
        });
    }
    /**
     * Gets the form object.
     *
     * @returns {Object} - The form JSON schema.
     */
    get form() {
        if (!this._form) {
            this._form = {
                components: []
            };
        }
        return this._form;
    }
    /**
     * Sets the form value.
     *
     * @alias setForm
     * @param {Object} form - The form schema object.
     */
    set form(form) {
        this.setForm(form);
    }
    /**
     * Returns the submission object that was set within this form.
     *
     * @returns {Object}
     */
    get submission() {
        return this.getValue();
    }
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
    set submission(submission) {
        this.setSubmission(submission);
    }
    /**
     * Sets a submission and returns the promise when it is ready.
     * @param submission
     * @param flags
     * @return {Promise.<TResult>}
     */
    setSubmission(submission, flags = {}) {
        flags = Object.assign(Object.assign({}, flags), { fromSubmission: lodash_1.default.has(flags, 'fromSubmission') ? flags.fromSubmission : true });
        return this.onSubmission = this.formReady.then((resolveFlags) => {
            if (resolveFlags) {
                flags = Object.assign(Object.assign({}, flags), resolveFlags);
            }
            this.submissionSet = true;
            this.triggerChange(flags);
            this.emit('beforeSetSubmission', submission);
            this.setValue(submission, flags);
            return this.submissionReadyResolve(submission);
        }, (err) => this.submissionReadyReject(err)).catch((err) => this.submissionReadyReject(err));
    }
    handleDraftError(errName, errDetails, restoreDraft) {
        const errorMessage = lodash_1.default.trim(`${this.t(errName)} ${errDetails || ''}`);
        console.warn(errorMessage);
        this.emit(restoreDraft ? 'restoreDraftError' : 'saveDraftError', errDetails || errorMessage);
    }
    /**
     * Saves a submission draft.
     */
    saveDraft() {
        if (!this.draftEnabled) {
            return;
        }
        if (!this.formio) {
            this.handleDraftError('saveDraftInstanceError');
            return;
        }
        if (!Formio_1.Formio.getUser()) {
            this.handleDraftError('saveDraftAuthError');
            return;
        }
        const draft = (0, utils_1.fastCloneDeep)(this.submission);
        draft.state = 'draft';
        if (!this.savingDraft) {
            this.emit('saveDraftBegin');
            this.savingDraft = true;
            this.formio.saveSubmission(draft).then((sub) => {
                // Set id to submission to avoid creating new draft submission
                this.submission._id = sub._id;
                this.savingDraft = false;
                this.emit('saveDraft', sub);
            })
                .catch(err => {
                this.savingDraft = false;
                this.handleDraftError('saveDraftError', err);
            });
        }
    }
    /**
     * Restores a draft submission based on the user who is authenticated.
     *
     * @param {userId} - The user id where we need to restore the draft from.
     */
    restoreDraft(userId) {
        const formio = this.formio || this.options.formio;
        if (!formio) {
            this.handleDraftError('restoreDraftInstanceError', null, true);
            return;
        }
        this.savingDraft = true;
        formio.loadSubmissions({
            params: {
                state: 'draft',
                owner: userId
            }
        }).then(submissions => {
            if (submissions.length > 0 && !this.options.skipDraftRestore) {
                const draft = (0, utils_1.fastCloneDeep)(submissions[0]);
                return this.setSubmission(draft).then(() => {
                    this.draftEnabled = true;
                    this.savingDraft = false;
                    this.emit('restoreDraft', draft);
                });
            }
            // Enable drafts so that we can keep track of changes.
            this.draftEnabled = true;
            this.savingDraft = false;
            this.emit('restoreDraft', null);
        })
            .catch(err => {
            this.draftEnabled = true;
            this.savingDraft = false;
            this.handleDraftError('restoreDraftError', err, true);
        });
    }
    get schema() {
        const schema = (0, utils_1.fastCloneDeep)(lodash_1.default.omit(this._form, ['components']));
        schema.components = [];
        this.eachComponent((component) => schema.components.push(component.schema));
        return schema;
    }
    mergeData(_this, _that) {
        lodash_1.default.mergeWith(_this, _that, (thisValue, thatValue) => {
            if (Array.isArray(thisValue) && Array.isArray(thatValue) && thisValue.length !== thatValue.length) {
                return thatValue;
            }
        });
    }
    setValue(submission, flags = {}) {
        if (!submission || !submission.data) {
            submission = {
                data: {},
                metadata: submission.metadata,
            };
        }
        // Metadata needs to be available before setValue
        this._submission.metadata = submission.metadata || {};
        this.editing = !!submission._id;
        // Set the timezone in the options if available.
        if (!this.options.submissionTimezone &&
            submission.metadata &&
            submission.metadata.timezone) {
            this.options.submissionTimezone = submission.metadata.timezone;
        }
        const changed = super.setValue(submission.data, flags);
        if (!flags.sanitize) {
            this.mergeData(this.data, submission.data);
        }
        submission.data = this.data;
        this._submission = submission;
        return changed;
    }
    getValue() {
        if (!this._submission.data) {
            this._submission.data = {};
        }
        if (this.viewOnly) {
            return this._submission;
        }
        const submission = this._submission;
        submission.data = this.data;
        return this._submission;
    }
    /**
     * Build the form.
     */
    init() {
        if (this.options.submission) {
            const submission = lodash_1.default.extend({}, this.options.submission);
            this._submission = submission;
            this._data = submission.data;
        }
        else {
            this._submission = this._submission || { data: {} };
        }
        // Remove any existing components.
        if (this.components && this.components.length) {
            this.destroyComponents();
            this.components = [];
        }
        if (this.component) {
            this.component.components = this.form ? this.form.components : [];
        }
        else {
            this.component = this.form;
        }
        this.component.type = 'form';
        this.component.input = false;
        this.addComponents();
        this.on('submitButton', options => {
            this.submit(false, options).catch(e => {
                options.instance.loading = false;
                return e !== false && e !== undefined && console.log(e);
            });
        }, true);
        this.on('checkValidity', (data) => this.validate(data, { dirty: true, process: 'change' }), true);
        this.on('requestUrl', (args) => (this.submitUrl(args.url, args.headers)), true);
        this.on('resetForm', () => this.resetValue(), true);
        this.on('deleteSubmission', () => this.deleteSubmission(), true);
        this.on('refreshData', () => this.updateValue(), true);
        this.executeFormController();
        return this.formReady;
    }
    executeFormController() {
        // If no controller value or
        // hidden and set to clearOnHide (Don't calculate a value for a hidden field set to clear when hidden)
        if (!this.form || !this.form.controller
            || ((!this.visible || this.component.hidden) && this.component.clearOnHide && !this.rootPristine)) {
            return false;
        }
        this.formReady.then(() => {
            this.evaluate(this.form.controller, {
                components: this.components,
                instance: this,
            });
        });
    }
    teardown() {
        this.emit('formDelete', this.id);
        delete Formio_1.Formio.forms[this.id];
        delete this.executeShortcuts;
        delete this.triggerSaveDraft;
        super.teardown();
    }
    destroy(all = false) {
        this.off('submitButton');
        this.off('checkValidity');
        this.off('requestUrl');
        this.off('resetForm');
        this.off('deleteSubmission');
        this.off('refreshData');
        return super.destroy(all);
    }
    build(element) {
        if (element || this.element) {
            return this.ready.then(() => {
                element = element || this.element;
                super.build(element);
            });
        }
        return this.ready;
    }
    getClassName() {
        let classes = 'formio-form';
        if (this.options.readOnly) {
            classes += ' formio-read-only';
        }
        return classes;
    }
    render() {
        return super.render(this.renderTemplate('webform', {
            classes: this.getClassName(),
            children: this.renderComponents(),
        }), this.builderMode ? 'builder' : 'form', true);
    }
    redraw() {
        // Don't bother if we have not built yet.
        if (!this.element) {
            return Promise.resolve();
        }
        this.clear();
        this.setContent(this.element, this.render());
        return this.attach(this.element);
    }
    attach(element) {
        this.setElement(element);
        this.loadRefs(element, { webform: 'single' });
        const childPromise = this.attachComponents(this.refs.webform);
        this.addEventListener(document, 'keydown', this.executeShortcuts);
        this.currentForm = this;
        this.hook('attachWebform', element, this);
        return childPromise.then(() => {
            this.emit('render', this.element);
            return this.setValue(this._submission, {
                noUpdateEvent: true,
            });
        });
    }
    hasRequiredFields() {
        let result = false;
        (0, formUtils_1.eachComponent)(this.form.components, (component) => {
            if (component.validate.required) {
                result = true;
                return true;
            }
        }, true);
        return result;
    }
    resetValue() {
        lodash_1.default.each(this.getComponents(), (comp) => (comp.resetValue()));
        this.setPristine(true);
        this.onChange({ resetValue: true });
    }
    /**
     * Sets a new alert to display in the error dialog of the form.
     *
     * @param {string} type - The type of alert to display. "danger", "success", "warning", etc.
     * @param {string} message - The message to show in the alert.
     * @param {Object} options
     */
    setAlert(type, message, options) {
        if (!type && this.submitted) {
            if (this.alert) {
                if (this.refs.errorRef && this.refs.errorRef.length) {
                    this.refs.errorRef.forEach(el => {
                        this.removeEventListener(el, 'click');
                        this.removeEventListener(el, 'keypress');
                    });
                }
                this.removeChild(this.alert);
                this.alert = null;
            }
            return;
        }
        if (this.options.noAlerts) {
            if (!message) {
                this.emit('error', false);
            }
            return;
        }
        if (this.alert) {
            try {
                if (this.refs.errorRef && this.refs.errorRef.length) {
                    this.refs.errorRef.forEach(el => {
                        this.removeEventListener(el, 'click');
                        this.removeEventListener(el, 'keypress');
                    });
                }
                this.removeChild(this.alert);
                this.alert = null;
            }
            catch (err) {
                // ignore
            }
        }
        if (message) {
            const attrs = {
                class: (options && options.classes) || `alert alert-${type}`,
                id: `error-list-${this.id}`,
            };
            const templateOptions = {
                message: message instanceof HTMLElement ? message.outerHTML : message,
                attrs: attrs,
                type
            };
            this.alert = (0, utils_1.convertStringToHTMLElement)(this.renderTemplate('alert', templateOptions), `#${attrs.id}`);
        }
        if (!this.alert) {
            return;
        }
        this.loadRefs(this.alert, { errorRef: 'multiple' });
        if (this.refs.errorRef && this.refs.errorRef.length) {
            this.refs.errorRef.forEach(el => {
                this.addEventListener(el, 'click', (e) => {
                    const key = e.currentTarget.dataset.componentKey;
                    this.focusOnComponent(key);
                });
                this.addEventListener(el, 'keydown', (e) => {
                    if (e.keyCode === 13) {
                        e.preventDefault();
                        const key = e.currentTarget.dataset.componentKey;
                        this.focusOnComponent(key);
                    }
                });
            });
        }
        this.prepend(this.alert);
    }
    /**
     * Focus on selected component.
     *
     * @param {string} key - The key of selected component.
     * @returns {*}
     */
    focusOnComponent(key) {
        if (key) {
            const component = this.getComponent(key);
            if (component) {
                component.focus();
            }
        }
    }
    /**
     * Show the errors of this form within the alert dialog.
     *
     * @param {Object} error - An optional additional error to display along with the component errors.
     * @returns {*}
     */
    /* eslint-disable no-unused-vars */
    showErrors(errors, triggerEvent) {
        this.loading = false;
        if (!Array.isArray(errors)) {
            errors = [errors];
        }
        errors = errors.concat(this.customErrors).filter((err) => !!err);
        if (!errors.length) {
            this.setAlert(false);
            return;
        }
        // Mark any components as invalid if in a custom message.
        errors.forEach((err) => {
            const { components = [] } = err;
            if (err.component) {
                components.push(err.component);
            }
            if (err.path) {
                components.push(err.path);
            }
            components.forEach((path) => {
                const originalPath = (0, utils_1.getStringFromComponentPath)(path);
                const component = this.getComponent(path, lodash_1.default.identity, originalPath);
                if (err.fromServer) {
                    if (component.serverErrors) {
                        component.serverErrors.push(err);
                    }
                    else {
                        component.serverErrors = [err];
                    }
                }
                const components = lodash_1.default.compact(Array.isArray(component) ? component : [component]);
                components.forEach((component) => component.setCustomValidity(err.message, true));
            });
        });
        const displayedErrors = [];
        if (errors.length) {
            errors = lodash_1.default.uniqBy(errors, error => error.message);
            const createListItem = (message, index) => {
                var _a, _b, _c;
                const err = errors[index];
                const messageFromIndex = !lodash_1.default.isUndefined(index) && errors && errors[index];
                const keyOrPath = ((messageFromIndex === null || messageFromIndex === void 0 ? void 0 : messageFromIndex.formattedKeyOrPath) || (messageFromIndex === null || messageFromIndex === void 0 ? void 0 : messageFromIndex.path) || ((_a = messageFromIndex === null || messageFromIndex === void 0 ? void 0 : messageFromIndex.context) === null || _a === void 0 ? void 0 : _a.path)) || (((_b = err.context) === null || _b === void 0 ? void 0 : _b.component) && ((_c = err.context) === null || _c === void 0 ? void 0 : _c.component.key)) || (err.component && err.component.key) || err.fromServer && err.path;
                const formattedKeyOrPath = keyOrPath ? (0, utils_1.getStringFromComponentPath)(keyOrPath) : '';
                if (typeof err !== 'string' && !err.formattedKeyOrPath) {
                    err.formattedKeyOrPath = formattedKeyOrPath;
                }
                return {
                    message: (0, utils_1.unescapeHTML)(message),
                    keyOrPath: formattedKeyOrPath
                };
            };
            errors.forEach(({ message, context, fromServer, component }, index) => {
                const text = !(component === null || component === void 0 ? void 0 : component.label) || (context === null || context === void 0 ? void 0 : context.hasLabel) || fromServer
                    ? this.t('alertMessage', { message: this.t(message) })
                    : this.t('alertMessageWithLabel', {
                        label: this.t(component === null || component === void 0 ? void 0 : component.label),
                        message: this.t(message),
                    });
                displayedErrors.push(createListItem(text, index));
            });
        }
        const errorsList = this.renderTemplate('errorsList', { errors: displayedErrors });
        this.root.setAlert('danger', errorsList);
        if (triggerEvent) {
            this.emit('error', errors);
        }
        return errors;
    }
    /* eslint-enable no-unused-vars */
    /**
     * Called when the submission has completed, or if the submission needs to be sent to an external library.
     *
     * @param {Object} submission - The submission object.
     * @param {boolean} saved - Whether or not this submission was saved to the server.
     * @returns {object} - The submission object.
     */
    onSubmit(submission, saved) {
        var _a;
        this.loading = false;
        this.submitting = false;
        this.setPristine(true);
        // We want to return the submitted submission and setValue will mutate the submission so cloneDeep it here.
        this.setValue((0, utils_1.fastCloneDeep)(submission), {
            noValidate: true,
            noCheck: true
        });
        this.setAlert('success', `<p>${this.t('complete')}</p>`);
        // Cancel triggered saveDraft to prevent overriding the submitted state
        if (this.draftEnabled && ((_a = this.triggerSaveDraft) === null || _a === void 0 ? void 0 : _a.cancel)) {
            this.triggerSaveDraft.cancel();
        }
        this.emit('submit', submission, saved);
        if (saved) {
            this.emit('submitDone', submission);
        }
        return submission;
    }
    normalizeError(error) {
        if (error) {
            if (typeof error === 'object' && 'details' in error) {
                error = error.details;
            }
            if (typeof error === 'string') {
                error = { message: error };
            }
        }
        return error;
    }
    /**
     * Called when an error occurs during the submission.
     *
     * @param {Object} error - The error that occured.
     */
    onSubmissionError(error) {
        error = this.normalizeError(error);
        this.submitting = false;
        this.setPristine(false);
        this.emit('submitError', error || this.errors);
        // Allow for silent cancellations (no error message, no submit button error state)
        if (error && error.silent) {
            this.emit('change', { isValid: true }, { silent: true });
            return false;
        }
        const errors = this.showErrors(error, true);
        if (this.root && this.root.alert) {
            this.scrollIntoView(this.root.alert);
        }
        return errors;
    }
    /**
     * Trigger the change event for this form.
     *
     * @param changed
     * @param flags
     */
    onChange(flags, changed, modified, changes) {
        flags = flags || {};
        let isChangeEventEmitted = false;
        super.onChange(flags, true);
        const value = lodash_1.default.clone(this.submission);
        flags.changed = value.changed = changed;
        flags.changes = changes;
        if (modified && this.pristine) {
            this.pristine = false;
        }
        this.checkData(value.data, flags);
        const shouldValidate = !flags.noValidate || flags.fromIFrame || (flags.fromSubmission && this.rootPristine && this.pristine && flags.changed);
        const errors = shouldValidate ? this.validate(value.data, Object.assign(Object.assign({}, flags), { process: 'change' })) : [];
        value.isValid = errors.length === 0;
        this.loading = false;
        if (this.submitted) {
            // show server errors while they are not cleaned/fixed
            const nonComponentServerErrors = lodash_1.default.filter(this.serverErrors || [], err => !err.component && !err.path);
            this.showErrors(nonComponentServerErrors.length ? nonComponentServerErrors : errors);
        }
        // See if we need to save the draft of the form.
        if (modified && this.options.saveDraft) {
            this.triggerSaveDraft();
        }
        if (!flags || !flags.noEmit) {
            this.emit('change', value, flags, modified);
            isChangeEventEmitted = true;
        }
        // The form is initialized after the first change event occurs.
        if (isChangeEventEmitted && !this.initialized) {
            this.emit('initialized');
            this.initialized = true;
        }
    }
    /**
     * Send a delete request to the server.
     */
    deleteSubmission() {
        return this.formio.deleteSubmission()
            .then(() => {
            this.emit('submissionDeleted', this.submission);
            this.resetValue();
        });
    }
    /**
     * Cancels the submission.
     *
     * @alias reset
     */
    cancel(noconfirm) {
        const shouldReset = this.hook('beforeCancel', true);
        if (shouldReset && (noconfirm || confirm(this.t('confirmCancel')))) {
            this.resetValue();
            return true;
        }
        else {
            this.emit('cancelSubmit');
            return false;
        }
    }
    setMetadata(submission) {
        // Add in metadata about client submitting the form
        submission.metadata = submission.metadata || {};
        lodash_1.default.defaults(submission.metadata, {
            timezone: lodash_1.default.get(this, '_submission.metadata.timezone', (0, utils_1.currentTimezone)()),
            offset: parseInt(lodash_1.default.get(this, '_submission.metadata.offset', (0, moment_1.default)().utcOffset()), 10),
            origin: document.location.origin,
            referrer: document.referrer,
            browserName: navigator.appName,
            userAgent: navigator.userAgent,
            pathName: window.location.pathname,
            onLine: navigator.onLine
        });
    }
    submitForm(options = {}) {
        this.clearServerErrors();
        return new Promise((resolve, reject) => {
            // Read-only forms should never submit.
            if (this.options.readOnly) {
                return resolve({
                    submission: this.submission,
                    saved: false
                });
            }
            const submission = (0, utils_1.fastCloneDeep)(this.submission || {});
            this.setMetadata(submission);
            submission.state = options.state || submission.state || 'submitted';
            const isDraft = (submission.state === 'draft');
            this.hook('beforeSubmit', Object.assign(Object.assign({}, submission), { component: options.component }), (err, data) => {
                var _a;
                if (err) {
                    return reject(err);
                }
                submission._vnote = data && data._vnote ? data._vnote : '';
                try {
                    if (!isDraft && !options.noValidate) {
                        if (!submission.data) {
                            return reject('Invalid Submission');
                        }
                        const errors = this.validate(submission.data, {
                            dirty: true,
                            silentCheck: false,
                            process: 'submit'
                        });
                        if (errors.length || ((_a = options.beforeSubmitResults) === null || _a === void 0 ? void 0 : _a.some((result) => result.status === 'rejected'))) {
                            return reject(errors);
                        }
                    }
                }
                catch (err) {
                    console.error(err);
                }
                this.everyComponent((comp) => {
                    if (submission._vnote && comp.type === 'form' && comp.component.reference) {
                        lodash_1.default.get(submission.data, comp.path, {})._vnote = submission._vnote;
                    }
                    const { persistent } = comp.component;
                    if (persistent === 'client-only') {
                        lodash_1.default.unset(submission.data, comp.path);
                    }
                });
                this.hook('customValidation', Object.assign(Object.assign({}, submission), { component: options.component }), (err) => {
                    if (err) {
                        // If string is returned, cast to object.
                        if (typeof err === 'string') {
                            err = {
                                message: err
                            };
                        }
                        // Ensure err is an array.
                        err = Array.isArray(err) ? err : [err];
                        return reject(err);
                    }
                    this.loading = true;
                    // Use the form action to submit the form if available.
                    if (this._form && this._form.action) {
                        const method = (submission.data._id && this._form.action.includes(submission.data._id)) ? 'PUT' : 'POST';
                        return Formio_1.Formio.makeStaticRequest(this._form.action, method, submission, this.formio ? this.formio.options : {})
                            .then((result) => resolve({
                            submission: result,
                            saved: true,
                        }))
                            .catch((error) => {
                            this.setServerErrors(error);
                            return reject(error);
                        });
                    }
                    const submitFormio = this.formio;
                    if (this.nosubmit || !submitFormio) {
                        return resolve({
                            submission,
                            saved: false,
                        });
                    }
                    // If this is an actionUrl, then make sure to save the action and not the submission.
                    const submitMethod = submitFormio.actionUrl ? 'saveAction' : 'saveSubmission';
                    submitFormio[submitMethod](submission)
                        .then((result) => resolve({
                        submission: result,
                        saved: true,
                    }))
                        .catch((error) => {
                        this.setServerErrors(error);
                        return reject(error);
                    });
                });
            });
        });
    }
    setServerErrors(error) {
        if (error.details) {
            this.serverErrors = error.details.filter((err) => err.level ? err.level === 'error' : err).map((err) => {
                err.fromServer = true;
                return err;
            });
        }
        else if (typeof error === 'string') {
            this.serverErrors = [{ fromServer: true, level: 'error', message: error }];
        }
    }
    executeSubmit(options) {
        this.submitted = true;
        this.submitting = true;
        return this.submitForm(options)
            .then(({ submission, saved }) => this.onSubmit(submission, saved))
            .then((results) => {
            this.submissionInProcess = false;
            return results;
        })
            .catch((err) => {
            this.submissionInProcess = false;
            return Promise.reject(this.onSubmissionError(err));
        });
    }
    clearServerErrors() {
        var _a;
        (_a = this.serverErrors) === null || _a === void 0 ? void 0 : _a.forEach((error) => {
            if (error.path) {
                const pathArray = (0, utils_1.getArrayFromComponentPath)(error.path);
                const component = this.getComponent(pathArray, lodash_1.default.identity, error.formattedKeyOrPath);
                if (component) {
                    component.serverErrors = [];
                }
            }
        });
        this.serverErrors = [];
    }
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
    submit(before = null, options = {}) {
        this.submissionInProcess = true;
        if (!before) {
            return this.beforeSubmit(options).then(() => this.executeSubmit(options));
        }
        else {
            return this.executeSubmit(options);
        }
    }
    submitUrl(URL, headers) {
        if (!URL) {
            return console.warn('Missing URL argument');
        }
        const submission = this.submission || {};
        const API_URL = URL;
        const settings = {
            method: 'POST',
            headers: {}
        };
        if (headers && headers.length > 0) {
            headers.map((e) => {
                if (e.header !== '' && e.value !== '') {
                    settings.headers[e.header] = this.interpolate(e.value, submission);
                }
            });
        }
        if (API_URL && settings) {
            Formio_1.Formio.makeStaticRequest(API_URL, settings.method, submission, { headers: settings.headers }).then(() => {
                this.emit('requestDone');
                this.setAlert('success', '<p> Success </p>');
            }).catch((e) => {
                const message = `${e.statusText ? e.statusText : ''} ${e.status ? e.status : e}`;
                this.emit('error', message);
                console.error(message);
                this.setAlert('danger', `<p> ${message} </p>`);
                return Promise.reject(this.onSubmissionError(e));
            });
        }
        else {
            this.emit('error', 'You should add a URL to this button.');
            this.setAlert('warning', 'You should add a URL to this button.');
            return console.warn('You should add a URL to this button.');
        }
    }
    triggerRecaptcha() {
        if (!this || !this.components) {
            return;
        }
        const recaptchaComponent = (0, utils_1.searchComponents)(this.components, {
            'component.type': 'recaptcha',
            'component.eventType': 'formLoad'
        });
        if (recaptchaComponent.length > 0) {
            recaptchaComponent[0].verify(`${this.form.name ? this.form.name : 'form'}Load`);
        }
    }
    set nosubmit(value) {
        this._nosubmit = !!value;
        this.emit('nosubmit', this._nosubmit);
    }
    get nosubmit() {
        return this._nosubmit || false;
    }
    get conditions() {
        var _a, _b;
        return (_b = (_a = this.schema.settings) === null || _a === void 0 ? void 0 : _a.conditions) !== null && _b !== void 0 ? _b : [];
    }
    get variables() {
        var _a, _b;
        return (_b = (_a = this.schema.settings) === null || _a === void 0 ? void 0 : _a.variables) !== null && _b !== void 0 ? _b : [];
    }
}
exports.default = Webform;
Webform.setBaseUrl = Formio_1.Formio.setBaseUrl;
Webform.setApiUrl = Formio_1.Formio.setApiUrl;
Webform.setAppUrl = Formio_1.Formio.setAppUrl;
