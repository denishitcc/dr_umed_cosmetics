export default class ReCaptchaComponent extends Component {
    static get builderInfo(): {
        title: string;
        group: string;
        icon: string;
        documentation: string;
        weight: number;
        schema: any;
    };
    static savedValueTypes(): never[];
    render(): any;
    recaptchaResult: any;
    createInput(): void;
    recaptchaApiReady: any;
    createLabel(): void;
    verify(actionName: any): Promise<void>;
    recaptchaVerifiedPromise: Promise<any> | undefined;
    isLoading: boolean | undefined;
    loading: boolean | undefined;
    sendVerificationRequest(token: any): any;
    checkComponentValidity(data: any, dirty: any, row: any, options?: {}, errors?: any[]): boolean | Promise<boolean>;
    normalizeValue(newValue: any): any;
}
import Component from '../_classes/component/Component';
