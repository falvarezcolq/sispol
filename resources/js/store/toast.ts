import { reactive } from 'vue';

interface Toast {
    message: string;
    type: 'success' | 'error' | 'info';
}

interface ToastState {
    toasts: Toast[];
}

const state = reactive<ToastState>({
    toasts: [],
});

function addToast(message: string, type: 'success' | 'error' | 'info' = 'info') {
    state.toasts.push({ message, type });
    setTimeout(() => {
        state.toasts.shift();
    }, 3000);
}

export default function useToast() {
    return {
        toasts: state.toasts,
        addToast,
    };
}