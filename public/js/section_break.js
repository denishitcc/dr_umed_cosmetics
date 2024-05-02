const Field = Formio.Components.components.field;
class sectionBreak extends Field {

    static schema(...extend) {
        return Field.schema({
            type: 'rating',
            label: 'section-break',
            key: 'rating',
        });
    }

    static get builderInfo() {
        return {
            title: 'Section Break',
            icon: 'star',
            group: 'advanced',
            documentation: '/userguide/#textfield',
            weight: 0,
            schema: sectionBreak.schema()
        };
    }

    constructor(component, options, data) {
        super(component, options, data);
    }

    init() {
        super.init();
    }

    get inputInfo() {
        const info = super.inputInfo;
        return info;
    }

    render(content) {
        // return super.render("<div>I am a rating component</div>");
        let component = `<hr>`
        // for (let i = 0; i < this.component.numOfIcons; i++) {
        //     component += this.component.icon;
        // }
        // component += `</div>`
        return super.render(component);
    }

    attach(element) {
        this.loadRefs(element, {
            customRef: 'single'
        });
        return super.attach(element);
    }

    detach() {
        return super.detach();
    }

    destroy() {
        return super.destroy();
    }

    normalizeValue(value, flags = {}) {
        return super.normalizeValue(value, flags);
    }

    getValue() {
        return super.getValue();
    }

    getValueAt(index) {
        return super.getValueAt(index);
    }

    setValue(value, flags = {}) {
        return super.setValue(value, flags);
    }

    setValueAt(index, value, flags = {}) {
        return super.setValueAt(index, value, flags);
    }

    updateValue(value, flags = {}) {
        return super.updateValue(...arguments);
    }
}