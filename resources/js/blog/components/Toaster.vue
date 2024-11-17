<script lang="ts" setup>
import type { Toast } from '@/blog/types/toast'

const { toasts, remove } = useToast()

function onUpdateOpen(open: boolean, toast: Toast) {
  if (!open) {
    remove(toast)
  }
}
const refs = ref<{ height: number }[]>([])
const height = computed(() => refs.value.reduce((acc, { height }) => acc + height + 16, 0))
function getOffset(index: number) {
  return refs.value.slice(index + 1).reduce((acc, { height }) => acc + height + 16, 0)
}
</script>

<template>
  <ToastProvider
    :duration="2500"
  >
    <Toast
      v-for="(toast, index) in toasts"
      ref="refs"
      :key="toast.id"
      :toast="toast"
      :style="{
        '--index': index,
        '--offset': getOffset(index),
        '--translate-factor': '-1px',
        '--transform': `translateY(calc(var(--offset) * var(--translate-factor)))`,
      }"
      class="absolute inset-x-0 bottom-0 z-[--index] transition-all duration-300 ease-out transform-custom data-[state=closed]:animate-[toast-closed_300ms_ease-out] data-[state=open]:animate-[toast-open_300ms_ease-out]"
      @update:open="onUpdateOpen($event, toast)"
    />

    <ToastViewport
      :style="{
        '--height': `${height}px`,
      }"
      class="fixed inset-x-4 bottom-4 z-20 flex h-[--height] flex-col focus:outline-none sm:w-full sm:max-w-sm sm:left-unset"
    />
  </ToastProvider>
</template>
