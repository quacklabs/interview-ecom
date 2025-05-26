export class StorageModule {
    private static instance: StorageModule;

    private constructor() {

    }

    public get(key: string): string | null {
        const item = localStorage.getItem(key);
        return item ? item : null;
    }

    public remove(key: string): void {
        localStorage.removeItem(key)
        return
    }

    public save(key: string, data: any) {
        localStorage.setItem(key, JSON.stringify(data));
    }

    public static getInstance(): StorageModule {
        if (!StorageModule.instance) {
            StorageModule.instance = new StorageModule();
        }
        return StorageModule.instance;
    }
}