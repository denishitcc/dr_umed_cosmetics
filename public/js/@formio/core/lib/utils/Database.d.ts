import { DataObject } from 'types/DataObject';
export declare abstract class Database {
    abstract findOne(scope: any, query: string): Promise<any>;
    abstract isUnique(data: DataObject): Promise<boolean>;
}
