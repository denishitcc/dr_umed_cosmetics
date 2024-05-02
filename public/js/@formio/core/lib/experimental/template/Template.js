"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
exports.Template = void 0;
const lodash_1 = require("lodash");
/**
 * Manages all the available templates which can be rendered.
 */
class Template {
    /**
     * Adds a collection of template frameworks to the renderer.
     * @param templates
     */
    static addTemplates(templates) {
        var framework = Template.framework;
        Template.templates = (0, lodash_1.merge)(Template.templates, templates);
        Template.framework = framework;
    }
    /**
     * Adds some templates to the existing template.
     * @param name
     * @param template
     */
    static addTemplate(name, template) {
        Template.templates[name] = (0, lodash_1.merge)(Template.current, template);
        if (Template.templates.hasOwnProperty(Template._framework)) {
            Template._current = Template.templates[Template._framework];
        }
    }
    /**
     * Extend an existing template.
     * @param name
     * @param template
     */
    static extendTemplate(name, template) {
        Template.templates[name] = (0, lodash_1.merge)(Template.templates[name], template);
        if (Template.templates.hasOwnProperty(Template._framework)) {
            Template._current = Template.templates[Template._framework];
        }
    }
    /**
     * Sets a template.
     * @param name
     * @param template
     */
    static setTemplate(name, template) {
        Template.addTemplate(name, template);
    }
    /**
     * Set the current template.
     */
    static set current(templates) {
        const defaultTemplates = Template.current;
        Template._current = (0, lodash_1.merge)(defaultTemplates, templates);
    }
    /**
     * Get the current template.
     */
    static get current() {
        return Template._current;
    }
    /**
     * Sets the current framework.
     */
    static set framework(framework) {
        Template._framework = framework;
        if (Template.templates.hasOwnProperty(framework)) {
            Template._current = Template.templates[framework];
        }
    }
    /**
     * Gets the current framework.
     */
    static get framework() {
        return Template._framework;
    }
    /**
     * Render a partial within the current template.
     * @param name
     * @param ctx
     * @param mode
     * @returns
     */
    static render(name, ctx, mode = 'html', defaultTemplate = null) {
        if (typeof name === 'function') {
            return name(ctx);
        }
        if (this.current[name] && this.current[name][mode]) {
            return this.current[name][mode](ctx);
        }
        if (defaultTemplate) {
            return defaultTemplate(ctx);
        }
        return 'Unknown template';
    }
}
exports.Template = Template;
Template.templates = {};
Template._current = {};
Template._framework = 'bootstrap';
