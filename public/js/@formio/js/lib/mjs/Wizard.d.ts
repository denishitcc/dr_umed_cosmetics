declare class Wizard extends Webform {
    /**
     * Constructor for wizard based forms
     * @param element Dom element to place this wizard.
     * @param {Object} options Options object, supported options are:
     *    - breadcrumbSettings.clickable: true (default) determines if the breadcrumb bar is clickable or not
     *    - buttonSettings.show*(Previous, Next, Cancel): true (default) determines if the button is shown or not
     *    - allowPrevious: false (default) determines if the breadcrumb bar is clickable or not for visited tabs
     */
    constructor(...args: any[]);
    pages: any[];
    prefixComps: any[];
    suffixComps: any[];
    components: any[];
    originalComponents: any[];
    page: number;
    currentPanel: any;
    currentPanels: any[] | null;
    currentNextPage: number;
    _seenPages: number[];
    subWizards: any[];
    allPages: any[];
    lastPromise: Promise<void>;
    enabledIndex: number;
    editMode: boolean;
    originalOptions: any;
    isLastPage(): any;
    getPages(args?: {}): any[];
    get hasExtraPages(): boolean;
    get localData(): any;
    isClickableDefined: any;
    isSecondInit: boolean | undefined;
    get wizardKey(): string;
    set wizard(form: Object);
    get wizard(): Object;
    get buttons(): {};
    get buttonOrder(): any;
    get renderContext(): {
        disableWizardSubmit: any;
        wizardKey: string;
        isBreadcrumbClickable: any;
        isSubForm: boolean;
        panels: any[];
        buttons: {};
        currentPage: number;
        buttonOrder: any;
    };
    prepareNavigationSettings(ctx: any): any;
    prepareHeaderSettings(ctx: any, headerType: any): any;
    redrawNavigation(): void;
    redrawHeader(): void;
    attach(element: any): Promise<void>;
    scrollPageToTop(): void;
    isBreadcrumbClickable(): any;
    isAllowPrevious(): any;
    handleNaviageteOnEnter(event: any): void;
    handleSaveOnEnter(event: any): void;
    attachNav(): void;
    emitWizardPageSelected(index: any): void;
    attachHeader(): void;
    detachNav(): void;
    detachHeader(): void;
    transformPages(): void;
    getSortedComponents({ components, originalComponents }: {
        components: any;
        originalComponents: any;
    }): any[];
    findRootPanel(component: any): any;
    setRootPanelId(component: any): void;
    establishPages(data?: any): any[];
    updatePages(): void;
    addComponents(): void;
    setPage(num: any): Promise<void>;
    pageFieldLogic(page: any): void;
    get currentPage(): any;
    getNextPage(): number | null;
    getPreviousPage(): number;
    beforeSubmit(): Promise<any[]>;
    beforePage(next: any): Promise<any>;
    emitNextPage(): void;
    nextPage(): Promise<void>;
    validateCurrentPage(flags?: {}): any;
    emitPrevPage(): void;
    prevPage(): Promise<void>;
    cancel(noconfirm: any): Promise<void> | Promise<number>;
    getPageIndexByKey(key: any): number;
    get schema(): Object;
    setComponentSchema(): void;
    setForm(form: any, flags: any): any;
    onSetForm(clonedForm: any, initialForm: any): void;
    setEditMode(submission: any): void;
    setValue(submission: any, flags: {} | undefined, ignoreEstablishment: any): any;
    isClickable(page: any, index: any): any;
    hasButton(name: any, nextPage?: number | null): any;
    pageId(page: any): any;
    onChange(flags: any, changed: any, modified: any, changes: any): void;
    checkValidity(data: any, dirty: any, row: any, currentPageOnly: any, childErrors?: any[]): any;
    focusOnComponent(key: any): any;
}
declare namespace Wizard {
    let setBaseUrl: any;
    let setApiUrl: any;
    let setAppUrl: any;
}
export default Wizard;
import Webform from './Webform';
