export default class NestedArrayComponent extends NestedDataComponent {
    static savedValueTypes(): string[];
    componentContext(component: any): any;
    get iteratableRows(): void;
    prevHasAddButton: any;
    checkAddButtonChanged(): void;
    checkData(data: any, flags: any, row: any): any;
    processRows(method: any, data: any, opts: any, defaultValue: any, silentCheck: any): any;
    validate(data: any, flags?: {}): any;
    checkRow(...args: any[]): any;
    processRow(method: any, data: any, opts: any, row: any, components: any, silentCheck: any): any;
    hasAddButton(): any;
    getComponent(path: any, fn: any, originalPath: any): any;
    everyComponent(fn: any, rowIndex: any, options?: {}): void;
    getComponents(rowIndex: any): any;
}
import NestedDataComponent from '../nesteddata/NestedDataComponent';
