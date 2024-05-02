declare namespace _default {
    export { form1 };
    export { form2 };
    export { form3 };
    export { form4 };
    export { form5 };
    export { form6 };
}
export default _default;
declare namespace form1 {
    let title: string;
    let name: string;
    let path: string;
    let type: string;
    let display: string;
    let components: ({
        label: string;
        tableView: boolean;
        key: string;
        type: string;
        input: boolean;
        collapsible?: undefined;
        conditional?: undefined;
        components?: undefined;
        disableOnInvalid?: undefined;
    } | {
        collapsible: boolean;
        key: string;
        conditional: {
            show: boolean;
            conjunction: string;
            conditions: {
                component: string;
                operator: string;
                value: boolean;
            }[];
        };
        type: string;
        label: string;
        input: boolean;
        tableView: boolean;
        components: ({
            label: string;
            optionsLabelPosition: string;
            inline: boolean;
            tableView: boolean;
            values: {
                label: string;
                value: string;
                shortcut: string;
            }[];
            key: string;
            type: string;
            input: boolean;
            rowDrafts?: undefined;
            conditional?: undefined;
            displayAsTable?: undefined;
            components?: undefined;
        } | {
            label: string;
            tableView: boolean;
            rowDrafts: boolean;
            key: string;
            conditional: {
                show: boolean;
                conjunction: string;
                conditions: {
                    component: string;
                    operator: string;
                    value: string;
                }[];
            };
            type: string;
            displayAsTable: boolean;
            input: boolean;
            components: ({
                label: string;
                applyMaskOn: string;
                tableView: boolean;
                key: string;
                type: string;
                input: boolean;
                mask?: undefined;
                delimiter?: undefined;
                requireDecimal?: undefined;
                inputFormat?: undefined;
                truncateMultipleSpaces?: undefined;
                calculateValue?: undefined;
            } | {
                label: string;
                applyMaskOn: string;
                mask: boolean;
                tableView: boolean;
                delimiter: boolean;
                requireDecimal: boolean;
                inputFormat: string;
                truncateMultipleSpaces: boolean;
                calculateValue: string;
                key: string;
                type: string;
                input: boolean;
            })[];
            optionsLabelPosition?: undefined;
            inline?: undefined;
            values?: undefined;
        })[];
        disableOnInvalid?: undefined;
    } | {
        type: string;
        label: string;
        key: string;
        disableOnInvalid: boolean;
        input: boolean;
        tableView: boolean;
        collapsible?: undefined;
        conditional?: undefined;
        components?: undefined;
    })[];
}
declare namespace form2 {
    let title_1: string;
    export { title_1 as title };
    let name_1: string;
    export { name_1 as name };
    let path_1: string;
    export { path_1 as path };
    let type_1: string;
    export { type_1 as type };
    let display_1: string;
    export { display_1 as display };
    let components_1: ({
        label: string;
        autoExpand: boolean;
        tableView: boolean;
        key: string;
        type: string;
        input: boolean;
        rowDrafts?: undefined;
        displayAsTable?: undefined;
        components?: undefined;
        disableOnInvalid?: undefined;
    } | {
        label: string;
        tableView: boolean;
        rowDrafts: boolean;
        key: string;
        type: string;
        displayAsTable: boolean;
        input: boolean;
        components: ({
            label: string;
            action: string;
            showValidations: boolean;
            tableView: boolean;
            key: string;
            type: string;
            custom: string;
            input: boolean;
            collapsible?: undefined;
            components?: undefined;
        } | {
            collapsible: boolean;
            key: string;
            type: string;
            label: string;
            input: boolean;
            tableView: boolean;
            components: ({
                label: string;
                optionsLabelPosition: string;
                inline: boolean;
                tableView: boolean;
                values: {
                    label: string;
                    value: string;
                    shortcut: string;
                }[];
                key: string;
                type: string;
                input: boolean;
                title?: undefined;
                collapsible?: undefined;
                customConditional?: undefined;
                components?: undefined;
            } | {
                title: string;
                collapsible: boolean;
                key: string;
                customConditional: string;
                type: string;
                label: string;
                input: boolean;
                tableView: boolean;
                components: {
                    label: string;
                    openWhenEmpty: boolean;
                    disableAddingRemovingRows: boolean;
                    tableView: boolean;
                    rowDrafts: boolean;
                    key: string;
                    conditional: {
                        show: boolean;
                        conjunction: string;
                        conditions: {
                            component: string;
                            operator: string;
                            value: string;
                        }[];
                    };
                    type: string;
                    displayAsTable: boolean;
                    input: boolean;
                    components: {
                        label: string;
                        tableView: boolean;
                        key: string;
                        type: string;
                        input: boolean;
                    }[];
                }[];
                optionsLabelPosition?: undefined;
                inline?: undefined;
                values?: undefined;
            })[];
            action?: undefined;
            showValidations?: undefined;
            custom?: undefined;
        })[];
        autoExpand?: undefined;
        disableOnInvalid?: undefined;
    } | {
        type: string;
        label: string;
        key: string;
        disableOnInvalid: boolean;
        input: boolean;
        tableView: boolean;
        autoExpand?: undefined;
        rowDrafts?: undefined;
        displayAsTable?: undefined;
        components?: undefined;
    })[];
    export { components_1 as components };
}
declare namespace form3 {
    let title_2: string;
    export { title_2 as title };
    let name_2: string;
    export { name_2 as name };
    let path_2: string;
    export { path_2 as path };
    let type_2: string;
    export { type_2 as type };
    let display_2: string;
    export { display_2 as display };
    let components_2: ({
        label: string;
        components: ({
            label: string;
            key: string;
            components: ({
                title: string;
                theme: string;
                collapsible: boolean;
                key: string;
                type: string;
                label: string;
                tableView: boolean;
                input: boolean;
                components: {
                    label: string;
                    optionsLabelPosition: string;
                    tableView: boolean;
                    defaultValue: {
                        creditRisk: boolean;
                        marketRisk: boolean;
                        operationalRisk: boolean;
                        counterpartyCreditRisk: boolean;
                        creditValuationRiskAdjustment: boolean;
                    };
                    values: {
                        label: string;
                        value: string;
                        shortcut: string;
                    }[];
                    key: string;
                    type: string;
                    input: boolean;
                    inputType: string;
                }[];
            } | {
                title: string;
                theme: string;
                collapsible: boolean;
                key: string;
                type: string;
                label: string;
                input: boolean;
                tableView: boolean;
                components: {
                    title: string;
                    collapsible: boolean;
                    key: string;
                    type: string;
                    label: string;
                    input: boolean;
                    tableView: boolean;
                    components: ({
                        label: string;
                        optionsLabelPosition: string;
                        customClass: string;
                        inline: boolean;
                        tableView: boolean;
                        values: {
                            label: string;
                            value: string;
                            shortcut: string;
                        }[];
                        key: string;
                        type: string;
                        labelWidth: number;
                        input: boolean;
                        conditional?: undefined;
                    } | {
                        label: string;
                        optionsLabelPosition: string;
                        customClass: string;
                        inline: boolean;
                        tableView: boolean;
                        values: {
                            label: string;
                            value: string;
                            shortcut: string;
                        }[];
                        key: string;
                        conditional: {
                            show: boolean;
                            conjunction: string;
                            conditions: {
                                component: string;
                                operator: string;
                                value: string;
                            }[];
                        };
                        type: string;
                        input: boolean;
                        labelWidth?: undefined;
                    })[];
                }[];
            })[];
        } | {
            label: string;
            key: string;
            components: {
                label: string;
                tableView: boolean;
                key: string;
                conditional: {
                    show: boolean;
                    conjunction: string;
                    conditions: {
                        component: string;
                        operator: string;
                        value: string;
                    }[];
                };
                type: string;
                input: boolean;
                components: {
                    label: string;
                    tableView: boolean;
                    key: string;
                    type: string;
                    input: boolean;
                    components: {
                        title: string;
                        theme: string;
                        customClass: string;
                        collapsible: boolean;
                        key: string;
                        type: string;
                        label: string;
                        input: boolean;
                        tableView: boolean;
                        components: ({
                            label: string;
                            labelPosition: string;
                            optionsLabelPosition: string;
                            inline: boolean;
                            tableView: boolean;
                            values: {
                                label: string;
                                value: string;
                                shortcut: string;
                            }[];
                            key: string;
                            customConditional: string;
                            type: string;
                            labelWidth: number;
                            input: boolean;
                            defaultValue?: undefined;
                            conditional?: undefined;
                            templates?: undefined;
                            addAnother?: undefined;
                            modal?: undefined;
                            saveRow?: undefined;
                            rowDrafts?: undefined;
                            displayAsTable?: undefined;
                            alwaysEnabled?: undefined;
                            components?: undefined;
                            path?: undefined;
                        } | {
                            label: string;
                            tableView: boolean;
                            defaultValue: boolean;
                            key: string;
                            conditional: {
                                show: boolean;
                                conjunction: string;
                                conditions: {
                                    component: string;
                                    operator: string;
                                    value: string;
                                }[];
                            };
                            type: string;
                            input: boolean;
                            labelPosition?: undefined;
                            optionsLabelPosition?: undefined;
                            inline?: undefined;
                            values?: undefined;
                            customConditional?: undefined;
                            labelWidth?: undefined;
                            templates?: undefined;
                            addAnother?: undefined;
                            modal?: undefined;
                            saveRow?: undefined;
                            rowDrafts?: undefined;
                            displayAsTable?: undefined;
                            alwaysEnabled?: undefined;
                            components?: undefined;
                            path?: undefined;
                        } | {
                            label: string;
                            tableView: boolean;
                            key: string;
                            conditional: {
                                show: boolean;
                                conjunction: string;
                                conditions: {
                                    component: string;
                                    operator: string;
                                    value: string;
                                }[];
                            };
                            type: string;
                            optionsLabelPosition: string;
                            input: boolean;
                            defaultValue: boolean;
                            labelPosition?: undefined;
                            inline?: undefined;
                            values?: undefined;
                            customConditional?: undefined;
                            labelWidth?: undefined;
                            templates?: undefined;
                            addAnother?: undefined;
                            modal?: undefined;
                            saveRow?: undefined;
                            rowDrafts?: undefined;
                            displayAsTable?: undefined;
                            alwaysEnabled?: undefined;
                            components?: undefined;
                            path?: undefined;
                        } | {
                            label: string;
                            tableView: boolean;
                            templates: {
                                header: string;
                                row: string;
                            };
                            addAnother: string;
                            modal: boolean;
                            saveRow: string;
                            rowDrafts: boolean;
                            key: string;
                            conditional: {
                                show: boolean;
                                conjunction: string;
                                conditions: {
                                    component: string;
                                    operator: string;
                                    value: string;
                                }[];
                            };
                            type: string;
                            displayAsTable: boolean;
                            alwaysEnabled: boolean;
                            input: boolean;
                            components: {
                                title: string;
                                theme: string;
                                collapsible: boolean;
                                key: string;
                                type: string;
                                label: string;
                                input: boolean;
                                tableView: boolean;
                                components: {
                                    title: string;
                                    collapsible: boolean;
                                    key: string;
                                    customConditional: string;
                                    type: string;
                                    label: string;
                                    input: boolean;
                                    tableView: boolean;
                                    components: {
                                        label: string;
                                        applyMaskOn: string;
                                        mask: boolean;
                                        tableView: boolean;
                                        delimiter: boolean;
                                        requireDecimal: boolean;
                                        inputFormat: string;
                                        truncateMultipleSpaces: boolean;
                                        key: string;
                                        type: string;
                                        input: boolean;
                                    }[];
                                }[];
                            }[];
                            path: string;
                            labelPosition?: undefined;
                            optionsLabelPosition?: undefined;
                            inline?: undefined;
                            values?: undefined;
                            customConditional?: undefined;
                            labelWidth?: undefined;
                            defaultValue?: undefined;
                        })[];
                    }[];
                }[];
            }[];
        })[];
        key: string;
        type: string;
        tableView: boolean;
        input: boolean;
        keyModified: boolean;
        action?: undefined;
        showValidations?: undefined;
        alwaysEnabled?: undefined;
        state?: undefined;
    } | {
        label: string;
        action: string;
        showValidations: boolean;
        tableView: boolean;
        key: string;
        type: string;
        input: boolean;
        alwaysEnabled: boolean;
        state: string;
        components?: undefined;
        keyModified?: undefined;
    })[];
    export { components_2 as components };
}
declare namespace form4 {
    let title_3: string;
    export { title_3 as title };
    let name_3: string;
    export { name_3 as name };
    let path_3: string;
    export { path_3 as path };
    let type_3: string;
    export { type_3 as type };
    let display_3: string;
    export { display_3 as display };
    let components_3: ({
        label: string;
        applyMaskOn: string;
        tableView: boolean;
        key: string;
        type: string;
        input: boolean;
        calculateValue?: undefined;
        calculateServer?: undefined;
        rowDrafts?: undefined;
        displayAsTable?: undefined;
        components?: undefined;
        disableOnInvalid?: undefined;
    } | {
        label: string;
        tableView: boolean;
        calculateValue: string;
        calculateServer: boolean;
        rowDrafts: boolean;
        key: string;
        type: string;
        displayAsTable: boolean;
        input: boolean;
        components: {
            label: string;
            applyMaskOn: string;
            autoExpand: boolean;
            tableView: boolean;
            key: string;
            type: string;
            input: boolean;
        }[];
        applyMaskOn?: undefined;
        disableOnInvalid?: undefined;
    } | {
        type: string;
        label: string;
        key: string;
        disableOnInvalid: boolean;
        input: boolean;
        tableView: boolean;
        applyMaskOn?: undefined;
        calculateValue?: undefined;
        calculateServer?: undefined;
        rowDrafts?: undefined;
        displayAsTable?: undefined;
        components?: undefined;
    })[];
    export { components_3 as components };
}
declare namespace form5 {
    let title_4: string;
    export { title_4 as title };
    let name_4: string;
    export { name_4 as name };
    let path_4: string;
    export { path_4 as path };
    let type_4: string;
    export { type_4 as type };
    let display_4: string;
    export { display_4 as display };
    let components_4: ({
        label: string;
        tableView: boolean;
        key: string;
        type: string;
        input: boolean;
        components: ({
            title: string;
            theme: string;
            collapsible: boolean;
            key: string;
            type: string;
            label: string;
            tableView: boolean;
            input: boolean;
            components: {
                label: string;
                widget: string;
                description: string;
                tableView: boolean;
                multiple: boolean;
                dataSrc: string;
                data: {
                    json: {
                        id: number;
                        longName: string;
                        leiCode: string;
                        countryCode: string;
                    }[];
                };
                template: string;
                customOptions: {
                    searchResultLimit: number;
                    fuseOptions: {
                        threshold: number;
                        distance: number;
                    };
                };
                validate: {
                    required: boolean;
                };
                key: string;
                type: string;
                input: boolean;
                searchThreshold: number;
            }[];
            path: string;
            customConditional?: undefined;
        } | {
            title: string;
            collapsible: boolean;
            key: string;
            customConditional: string;
            type: string;
            label: string;
            input: boolean;
            tableView: boolean;
            components: {
                label: string;
                tableView: boolean;
                key: string;
                customConditional: string;
                type: string;
                input: boolean;
                components: {
                    title: string;
                    collapsible: boolean;
                    key: string;
                    type: string;
                    label: string;
                    input: boolean;
                    tableView: boolean;
                    components: {
                        title: string;
                        collapsible: boolean;
                        key: string;
                        type: string;
                        label: string;
                        input: boolean;
                        tableView: boolean;
                        components: ({
                            label: string;
                            optionsLabelPosition: string;
                            customClass: string;
                            inline: boolean;
                            tableView: boolean;
                            values: {
                                label: string;
                                value: string;
                                shortcut: string;
                            }[];
                            validate: {
                                required: boolean;
                            };
                            key: string;
                            type: string;
                            labelWidth: number;
                            input: boolean;
                            templates?: undefined;
                            addAnother?: undefined;
                            modal?: undefined;
                            saveRow?: undefined;
                            rowDrafts?: undefined;
                            conditional?: undefined;
                            displayAsTable?: undefined;
                            components?: undefined;
                        } | {
                            label: string;
                            customClass: string;
                            tableView: boolean;
                            templates: {
                                header: string;
                                row: string;
                            };
                            addAnother: string;
                            modal: boolean;
                            saveRow: string;
                            validate: {
                                required: boolean;
                            };
                            rowDrafts: boolean;
                            key: string;
                            conditional: {
                                show: boolean;
                                conjunction: string;
                                conditions: {
                                    component: string;
                                    operator: string;
                                    value: string;
                                }[];
                            };
                            type: string;
                            displayAsTable: boolean;
                            input: boolean;
                            components: {
                                title: string;
                                theme: string;
                                collapsible: boolean;
                                key: string;
                                type: string;
                                label: string;
                                input: boolean;
                                tableView: boolean;
                                components: {
                                    label: string;
                                    applyMaskOn: string;
                                    tableView: boolean;
                                    validate: {
                                        required: boolean;
                                        maxLength: number;
                                    };
                                    key: string;
                                    type: string;
                                    input: boolean;
                                }[];
                            }[];
                            optionsLabelPosition?: undefined;
                            inline?: undefined;
                            values?: undefined;
                            labelWidth?: undefined;
                        })[];
                    }[];
                }[];
            }[];
            theme?: undefined;
            path?: undefined;
        })[];
        action?: undefined;
        showValidations?: undefined;
        state?: undefined;
    } | {
        label: string;
        action: string;
        showValidations: boolean;
        tableView: boolean;
        key: string;
        type: string;
        input: boolean;
        state: string;
        components?: undefined;
    })[];
    export { components_4 as components };
}
declare namespace form6 {
    let title_5: string;
    export { title_5 as title };
    let name_5: string;
    export { name_5 as name };
    let path_5: string;
    export { path_5 as path };
    let type_5: string;
    export { type_5 as type };
    let display_5: string;
    export { display_5 as display };
    let components_5: ({
        label: string;
        applyMaskOn: string;
        tableView: boolean;
        key: string;
        type: string;
        input: boolean;
        components?: undefined;
        disableOnInvalid?: undefined;
    } | {
        label: string;
        tableView: boolean;
        key: string;
        type: string;
        input: boolean;
        components: {
            label: string;
            tableView: boolean;
            rowDrafts: boolean;
            key: string;
            logic: {
                name: string;
                trigger: {
                    type: string;
                    simple: {
                        show: boolean;
                        conjunction: string;
                        conditions: {
                            component: string;
                            operator: string;
                            value: string;
                        }[];
                    };
                };
                actions: {
                    name: string;
                    type: string;
                    value: string;
                }[];
            }[];
            type: string;
            displayAsTable: boolean;
            input: boolean;
            components: ({
                label: string;
                applyMaskOn: string;
                mask: boolean;
                tableView: boolean;
                delimiter: boolean;
                requireDecimal: boolean;
                inputFormat: string;
                truncateMultipleSpaces: boolean;
                key: string;
                type: string;
                input: boolean;
                autoExpand?: undefined;
            } | {
                label: string;
                applyMaskOn: string;
                autoExpand: boolean;
                tableView: boolean;
                key: string;
                type: string;
                input: boolean;
                mask?: undefined;
                delimiter?: undefined;
                requireDecimal?: undefined;
                inputFormat?: undefined;
                truncateMultipleSpaces?: undefined;
            })[];
        }[];
        applyMaskOn?: undefined;
        disableOnInvalid?: undefined;
    } | {
        type: string;
        label: string;
        key: string;
        disableOnInvalid: boolean;
        input: boolean;
        tableView: boolean;
        applyMaskOn?: undefined;
        components?: undefined;
    })[];
    export { components_5 as components };
}
