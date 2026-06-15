// import { useState } from 'vue';
import { ref } from 'vue';

export function useToast() {
    let visibility = ref(false)
    let messages = ref<string[]>([])

    function resetMessages() {
        messages.value = []
    }

    function addMessage(message: string) {
        if (message) {
            messages.value.push(message)
            visibility.value = true
            setTimeout(() => {
                visibility.value = false
                resetMessages()
            }, 3000)
        }
    }

    return {
        messages,
        addMessage,
        visibility,
    }
}