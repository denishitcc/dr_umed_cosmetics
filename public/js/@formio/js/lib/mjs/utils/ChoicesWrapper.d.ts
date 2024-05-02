export namespace KEY_CODES {
    let BACK_KEY: number;
    let DELETE_KEY: number;
    let TAB_KEY: number;
    let ENTER_KEY: number;
    let A_KEY: number;
    let ESC_KEY: number;
    let UP_KEY: number;
    let DOWN_KEY: number;
    let PAGE_UP_KEY: number;
    let PAGE_DOWN_KEY: number;
}
export default ChoicesWrapper;
declare class ChoicesWrapper extends Choices {
    constructor(...args: any[]);
    _onTabKey({ activeItems, hasActiveDropdown }: {
        activeItems: any;
        hasActiveDropdown: any;
    }): void;
    isDirectionUsing: boolean;
    shouldOpenDropDown: boolean;
    _onTouchEnd(event: any): void;
    _handleButtonAction(activeItems: any, element: any): void;
    _onEnterKey(args: any): void;
    _onDirectionKey(...args: any[]): void;
    timeout: NodeJS.Timeout | undefined;
    _selectHighlightedChoice(activeItems: any): void;
    _onKeyDown(event: any): void;
    onSelectValue({ event, activeItems, hasActiveDropdown }: {
        event: any;
        activeItems: any;
        hasActiveDropdown: any;
    }): void;
    showDropdown(...args: any[]): void;
    hideDropdown(...args: any[]): void;
    _onBlur(...args: any[]): void;
}
import Choices from '@formio/choices.js';
