declare const _default: {
    type: string;
    addAnother: string;
    saveRow: string;
    weight: number;
    input: boolean;
    key: string;
    label: string;
    templates: {
        header: string;
        row: string;
    };
    components: ({
        type: string;
        key: string;
        display: string;
        input: boolean;
        components: ({
            type: string;
            title: any;
            theme: string;
            collapsible: boolean;
            collapsed: boolean;
            key: string;
            weight: any;
            components: ({
                type: string;
                tag: string;
                content: string;
            } | {
                type: string;
                title: string;
                collapsible: boolean;
                collapsed: boolean;
                style: {
                    'margin-bottom': string;
                };
                key: string;
                customConditional(): any;
                components: ({
                    type: string;
                    key: any;
                    rows: number;
                    editor: string;
                    hideLabel: boolean;
                    as: string;
                    input: boolean;
                    tag?: undefined;
                    content?: undefined;
                } | {
                    type: string;
                    tag: string;
                    content: string;
                    key?: undefined;
                    rows?: undefined;
                    editor?: undefined;
                    hideLabel?: undefined;
                    as?: undefined;
                    input?: undefined;
                })[];
            } | {
                type: string;
                title: string;
                collapsible: boolean;
                collapsed: boolean;
                key: string;
                components: ({
                    type: string;
                    tag: string;
                    content: string;
                    key?: undefined;
                    rows?: undefined;
                    editor?: undefined;
                    hideLabel?: undefined;
                    as?: undefined;
                    input?: undefined;
                } | {
                    type: string;
                    key: any;
                    rows: number;
                    editor: string;
                    hideLabel: boolean;
                    as: string;
                    input: boolean;
                    tag?: undefined;
                    content?: undefined;
                })[];
                style?: undefined;
                customConditional?: undefined;
            })[];
        } | {
            label: string;
            reorder: boolean;
            addAnotherPosition: string;
            layoutFixed: boolean;
            enableRowGroups: boolean;
            initEmpty: boolean;
            tableView: boolean;
            defaultValue: {}[];
            key: string;
            type: string;
            input: boolean;
            components: ({
                label: string;
                tableView: boolean;
                validate: {
                    required: boolean;
                    min?: undefined;
                    max?: undefined;
                    onlyAvailableItems?: undefined;
                };
                key: string;
                type: string;
                input: boolean;
                description?: undefined;
                mask?: undefined;
                spellcheck?: undefined;
                delimiter?: undefined;
                requireDecimal?: undefined;
                inputFormat?: undefined;
                tooltip?: undefined;
                data?: undefined;
                selectThreshold?: undefined;
                indexeddb?: undefined;
                placeholder?: undefined;
            } | {
                label: string;
                description: string;
                mask: boolean;
                spellcheck: boolean;
                tableView: boolean;
                delimiter: boolean;
                requireDecimal: boolean;
                inputFormat: string;
                validate: {
                    required: boolean;
                    min: number;
                    max: number;
                    onlyAvailableItems?: undefined;
                };
                key: string;
                type: string;
                input: boolean;
                tooltip?: undefined;
                data?: undefined;
                selectThreshold?: undefined;
                indexeddb?: undefined;
                placeholder?: undefined;
            } | {
                label: string;
                tooltip: string;
                tableView: boolean;
                data: {
                    values: {
                        label: string;
                        value: string;
                    }[];
                };
                selectThreshold: number;
                validate: {
                    onlyAvailableItems: boolean;
                    required?: undefined;
                    min?: undefined;
                    max?: undefined;
                };
                key: string;
                type: string;
                indexeddb: {
                    filter: {};
                };
                input: boolean;
                description?: undefined;
                mask?: undefined;
                spellcheck?: undefined;
                delimiter?: undefined;
                requireDecimal?: undefined;
                inputFormat?: undefined;
                placeholder?: undefined;
            } | {
                label: string;
                placeholder: string;
                tooltip: string;
                tableView: boolean;
                key: string;
                type: string;
                input: boolean;
                validate?: undefined;
                description?: undefined;
                mask?: undefined;
                spellcheck?: undefined;
                delimiter?: undefined;
                requireDecimal?: undefined;
                inputFormat?: undefined;
                data?: undefined;
                selectThreshold?: undefined;
                indexeddb?: undefined;
            })[];
            data?: undefined;
            selectThreshold?: undefined;
            validate?: undefined;
            indexeddb?: undefined;
            rowDrafts?: undefined;
            description?: undefined;
            tooltip?: undefined;
            multiple?: undefined;
            hideLabel?: undefined;
            editor?: undefined;
            as?: undefined;
        } | {
            label: string;
            tableView: boolean;
            data: {
                values: {
                    label: string;
                    value: string;
                }[];
            };
            selectThreshold: number;
            validate: {
                onlyAvailableItems: boolean;
            };
            key: string;
            type: string;
            indexeddb: {
                filter: {};
            };
            input: boolean;
            reorder?: undefined;
            addAnotherPosition?: undefined;
            layoutFixed?: undefined;
            enableRowGroups?: undefined;
            initEmpty?: undefined;
            defaultValue?: undefined;
            components?: undefined;
            rowDrafts?: undefined;
            description?: undefined;
            tooltip?: undefined;
            multiple?: undefined;
            hideLabel?: undefined;
            editor?: undefined;
            as?: undefined;
        } | {
            label: string;
            reorder: boolean;
            addAnotherPosition: string;
            layoutFixed: boolean;
            enableRowGroups: boolean;
            initEmpty: boolean;
            tableView: boolean;
            defaultValue: {}[];
            key: string;
            type: string;
            input: boolean;
            components: ({
                label: string;
                tableView: boolean;
                data: {
                    values: {
                        label: string;
                        value: string;
                    }[];
                };
                selectThreshold: number;
                validate: {
                    required: boolean;
                    onlyAvailableItems: boolean;
                };
                key: string;
                type: string;
                indexeddb: {
                    filter: {};
                };
                input: boolean;
                defaultValue?: undefined;
            } | {
                label: string;
                tableView: boolean;
                key: string;
                type: string;
                input: boolean;
                data?: undefined;
                selectThreshold?: undefined;
                validate?: undefined;
                indexeddb?: undefined;
                defaultValue?: undefined;
            } | {
                label: string;
                tableView: boolean;
                key: string;
                type: string;
                input: boolean;
                defaultValue: boolean;
                data?: undefined;
                selectThreshold?: undefined;
                validate?: undefined;
                indexeddb?: undefined;
            })[];
            data?: undefined;
            selectThreshold?: undefined;
            validate?: undefined;
            indexeddb?: undefined;
            rowDrafts?: undefined;
            description?: undefined;
            tooltip?: undefined;
            multiple?: undefined;
            hideLabel?: undefined;
            editor?: undefined;
            as?: undefined;
        } | {
            label: string;
            tableView: boolean;
            rowDrafts: boolean;
            key: string;
            type: string;
            input: boolean;
            components: ({
                type: string;
                title: any;
                theme: string;
                collapsible: boolean;
                collapsed: boolean;
                key: string;
                weight: any;
                components: ({
                    type: string;
                    tag: string;
                    content: string;
                } | {
                    type: string;
                    title: string;
                    collapsible: boolean;
                    collapsed: boolean;
                    style: {
                        'margin-bottom': string;
                    };
                    key: string;
                    customConditional(): any;
                    components: ({
                        type: string;
                        key: any;
                        rows: number;
                        editor: string;
                        hideLabel: boolean;
                        as: string;
                        input: boolean;
                        tag?: undefined;
                        content?: undefined;
                    } | {
                        type: string;
                        tag: string;
                        content: string;
                        key?: undefined;
                        rows?: undefined;
                        editor?: undefined;
                        hideLabel?: undefined;
                        as?: undefined;
                        input?: undefined;
                    })[];
                } | {
                    type: string;
                    title: string;
                    collapsible: boolean;
                    collapsed: boolean;
                    key: string;
                    components: ({
                        type: string;
                        tag: string;
                        content: string;
                        key?: undefined;
                        rows?: undefined;
                        editor?: undefined;
                        hideLabel?: undefined;
                        as?: undefined;
                        input?: undefined;
                    } | {
                        type: string;
                        key: any;
                        rows: number;
                        editor: string;
                        hideLabel: boolean;
                        as: string;
                        input: boolean;
                        tag?: undefined;
                        content?: undefined;
                    })[];
                    style?: undefined;
                    customConditional?: undefined;
                })[];
            } | {
                label: string;
                tableView: boolean;
                validate: {
                    required: boolean;
                };
                key: string;
                type: string;
                input: boolean;
                description?: undefined;
                mask?: undefined;
                spellcheck?: undefined;
                delimiter?: undefined;
                requireDecimal?: undefined;
                inputFormat?: undefined;
                tooltip?: undefined;
                defaultValue?: undefined;
            } | {
                label: string;
                description: string;
                mask: boolean;
                spellcheck: boolean;
                tableView: boolean;
                delimiter: boolean;
                requireDecimal: boolean;
                inputFormat: string;
                key: string;
                type: string;
                input: boolean;
                validate?: undefined;
                tooltip?: undefined;
                defaultValue?: undefined;
            } | {
                label: string;
                tooltip: string;
                tableView: boolean;
                key: string;
                type: string;
                input: boolean;
                defaultValue: boolean;
                validate?: undefined;
                description?: undefined;
                mask?: undefined;
                spellcheck?: undefined;
                delimiter?: undefined;
                requireDecimal?: undefined;
                inputFormat?: undefined;
            })[];
            reorder?: undefined;
            addAnotherPosition?: undefined;
            layoutFixed?: undefined;
            enableRowGroups?: undefined;
            initEmpty?: undefined;
            defaultValue?: undefined;
            data?: undefined;
            selectThreshold?: undefined;
            validate?: undefined;
            indexeddb?: undefined;
            description?: undefined;
            tooltip?: undefined;
            multiple?: undefined;
            hideLabel?: undefined;
            editor?: undefined;
            as?: undefined;
        } | {
            label: string;
            description: string;
            tableView: boolean;
            key: string;
            type: string;
            input: boolean;
            defaultValue: boolean;
            reorder?: undefined;
            addAnotherPosition?: undefined;
            layoutFixed?: undefined;
            enableRowGroups?: undefined;
            initEmpty?: undefined;
            components?: undefined;
            data?: undefined;
            selectThreshold?: undefined;
            validate?: undefined;
            indexeddb?: undefined;
            rowDrafts?: undefined;
            tooltip?: undefined;
            multiple?: undefined;
            hideLabel?: undefined;
            editor?: undefined;
            as?: undefined;
        } | {
            label: string;
            tooltip: string;
            tableView: boolean;
            multiple: boolean;
            key: string;
            type: string;
            input: boolean;
            reorder?: undefined;
            addAnotherPosition?: undefined;
            layoutFixed?: undefined;
            enableRowGroups?: undefined;
            initEmpty?: undefined;
            defaultValue?: undefined;
            components?: undefined;
            data?: undefined;
            selectThreshold?: undefined;
            validate?: undefined;
            indexeddb?: undefined;
            rowDrafts?: undefined;
            description?: undefined;
            hideLabel?: undefined;
            editor?: undefined;
            as?: undefined;
        } | {
            label: string;
            tooltip: string;
            tableView: boolean;
            key: string;
            type: string;
            input: boolean;
            defaultValue: boolean;
            reorder?: undefined;
            addAnotherPosition?: undefined;
            layoutFixed?: undefined;
            enableRowGroups?: undefined;
            initEmpty?: undefined;
            components?: undefined;
            data?: undefined;
            selectThreshold?: undefined;
            validate?: undefined;
            indexeddb?: undefined;
            rowDrafts?: undefined;
            description?: undefined;
            multiple?: undefined;
            hideLabel?: undefined;
            editor?: undefined;
            as?: undefined;
        } | {
            label: string;
            hideLabel: boolean;
            tableView: boolean;
            key: string;
            type: string;
            input: boolean;
            components: ({
                label: string;
                tooltip: string;
                tableView: boolean;
                data: {
                    values: {
                        label: string;
                        value: string;
                    }[];
                };
                selectThreshold: number;
                validate: {
                    onlyAvailableItems: boolean;
                };
                key: string;
                type: string;
                indexeddb: {
                    filter: {};
                };
                input: boolean;
                placeholder?: undefined;
                description?: undefined;
            } | {
                label: string;
                placeholder: string;
                description: string;
                tableView: boolean;
                key: string;
                type: string;
                input: boolean;
                tooltip?: undefined;
                data?: undefined;
                selectThreshold?: undefined;
                validate?: undefined;
                indexeddb?: undefined;
            })[];
            reorder?: undefined;
            addAnotherPosition?: undefined;
            layoutFixed?: undefined;
            enableRowGroups?: undefined;
            initEmpty?: undefined;
            defaultValue?: undefined;
            data?: undefined;
            selectThreshold?: undefined;
            validate?: undefined;
            indexeddb?: undefined;
            rowDrafts?: undefined;
            description?: undefined;
            tooltip?: undefined;
            multiple?: undefined;
            editor?: undefined;
            as?: undefined;
        } | {
            label: string;
            editor: string;
            tableView: boolean;
            key: string;
            type: string;
            input: boolean;
            as: string;
            reorder?: undefined;
            addAnotherPosition?: undefined;
            layoutFixed?: undefined;
            enableRowGroups?: undefined;
            initEmpty?: undefined;
            defaultValue?: undefined;
            components?: undefined;
            data?: undefined;
            selectThreshold?: undefined;
            validate?: undefined;
            indexeddb?: undefined;
            rowDrafts?: undefined;
            description?: undefined;
            tooltip?: undefined;
            multiple?: undefined;
            hideLabel?: undefined;
        })[];
        tableView: boolean;
        defaultValue: {
            data: {
                rulesSettings: {
                    name: string;
                    required: boolean;
                    message: string;
                }[];
                updateOn: string;
                required: boolean;
                levels: {
                    name: string;
                    maxEntropy: number;
                    style: string;
                }[];
                blackList: never[];
                template: string;
                location: {
                    insert: string;
                    selector: string;
                };
            };
        };
        customConditional({ row }: {
            row: any;
        }): boolean;
    } | {
        label: string;
        tableView: boolean;
        key: string;
        type: string;
        dataSrc: string;
        data: {
            custom: ({ instance }: {
                instance: any;
            }) => {
                value: string;
                label: any;
            }[];
        };
        input: boolean;
        validate: {
            required: boolean;
        };
    })[];
}[];
export default _default;
