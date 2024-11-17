<script lang="ts" setup>
const { isOpened, close } = useAuthenticationDialog()
</script>

<template>
  <DialogRoot :open="isOpened" @update:open="close">
    <DialogPortal>
      <DialogOverlay
        class="fixed inset-0 z-30 bg-black/50 backdrop-blur-sm data-[state=closed]:animate-[dialog-overlay-disappear_300ms_ease-out] data-[state=open]:animate-[dialog-overlay_300ms_ease-out] "
      />
      <DialogContent
        class="fixed left-1/2 top-1/2 z-40 mx-auto w-[calc(100%-2rem)] max-w-sm -translate-x-1/2 -translate-y-1/2 rounded-md bg-white p-4 shadow-md data-[state=closed]:animate-[dialog-disappear_150ms_ease-out] data-[state=open]:animate-[dialog-appear_150ms_ease-out] "
      >
        <DialogTitle
          class="text-lg font-semibold text-neutral-900"
        >
          Login to continue
        </DialogTitle>
        <DialogDescription
          class="mt-1 text-sm text-neutral-500 "
        >
          To perform this action, you need to login first.
        </DialogDescription>

        <div
          class="mt-4 flex flex-row items-center justify-end gap-2"
        >
          <DialogClose class="rounded px-2 py-1 text-sm tracking-wide text-neutral-700 transition duration-200 ease-in hover:bg-neutral-100 hover:text-neutral-900">
            Cancel
          </DialogClose>
          <a class="rounded border border-neutral-200 px-2 py-1 text-sm tracking-wide text-neutral-700 shadow-sm transition duration-200 ease-in hover:border-neutral-400 hover:text-neutral-900" href="/register">
            Register
          </a>
        </div>
      </DialogContent>
    </DialogPortal>
  </DialogRoot>
</template>
