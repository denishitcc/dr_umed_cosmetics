export default [
    {
        label: 'HTML Attributes',
        type: 'datamap',
        input: true,
        key: 'attributes',
        keyLabel: 'Attribute Name',
        valueComponent: {
            type: 'textfield',
            key: 'value',
            label: 'Attribute Value',
            input: true
        },
        tooltip: 'Provide a map of HTML attributes for component\'s input element (attributes provided by other component settings or other attributes generated by form.io take precedence over attributes in this grid)',
        addAnother: 'Add Attribute',
    },
    {
        type: 'panel',
        legend: 'PDF Overlay',
        title: 'PDF Overlay',
        key: 'overlay',
        tooltip: 'The settings inside apply only to the PDF forms.',
        weight: 2000,
        collapsible: true,
        collapsed: true,
        components: [
            {
                type: 'textfield',
                input: true,
                key: 'overlay.style',
                label: 'Style',
                placeholder: '',
                tooltip: 'Custom styles that should be applied to this component when rendered in PDF.'
            },
            {
                type: 'textfield',
                input: true,
                key: 'overlay.page',
                label: 'Page',
                placeholder: '',
                tooltip: 'The PDF page to place this component.'
            },
            {
                type: 'textfield',
                input: true,
                key: 'overlay.left',
                label: 'Left',
                placeholder: '',
                tooltip: 'The left margin within a page to place this component.'
            },
            {
                type: 'textfield',
                input: true,
                key: 'overlay.top',
                label: 'Top',
                placeholder: '',
                tooltip: 'The top margin within a page to place this component.'
            },
            {
                type: 'textfield',
                input: true,
                key: 'overlay.width',
                label: 'Width',
                placeholder: '',
                tooltip: 'The width of the component (in pixels).'
            },
            {
                type: 'textfield',
                input: true,
                key: 'overlay.height',
                label: 'Height',
                placeholder: '',
                tooltip: 'The height of the component (in pixels).'
            },
        ]
    },
];
