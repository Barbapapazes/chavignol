<script lang="ts" setup>
import type { Comment } from '@/blog/types/comment'

const { state: emojiState } = useEmoji()
const { state: commentsState } = useComments()

const { add } = useToast()
const queryCache = useQueryCache()

const { mutate: destroyComment } = useMutation({
  mutation: (commentId: number) => deletePostComment(window.postId, commentId),
  onMutate: (commentId) => {
    const oldComments = queryCache.getQueryData<Comment[]>(['comments', window.postId]) || []
    const commentIndex = oldComments.findIndex(comment => comment.id === commentId)

    let newComments = oldComments
    if (commentIndex !== -1) {
      newComments = oldComments.toSpliced(commentIndex, 1)

      queryCache.setQueryData(['comments', window.postId], newComments)
      queryCache.cancelQueries({ key: ['comments', window.postId], exact: true })
    }

    return { oldComments, newComments }
  },
  onSuccess: () => {
    add({
      type: 'success',
      title: 'Comment deleted',
      description: 'Your comment has been deleted successfully.',
    })
  },
  onError: (_, __, { newComments, oldComments }) => {
    if (newComments !== null && newComments === queryCache.getQueryData<Comment[]>(['comments', window.postId])) {
      queryCache.setQueryData(['comments', window.postId], oldComments)
    }

    add({
      type: 'error',
      title: 'Error',
      description: 'An error occurred while deleting your comment.',
    })
  },
  onSettled: () => {
    queryCache.invalidateQueries({ key: ['comments', window.postId] })
  },
})

function onDelete(comment: Comment) {
  destroyComment(comment.id)
}

const content = ref('')
const { mutate: storeComment, isLoading: isCreatingComment } = useMutation({
  mutation: (content: string) => storePostComment(window.postId, content),
  onSuccess: (newComment) => {
    queryCache.setQueryData(['comments', window.postId], [
      ...commentsState.value.data ?? [],
      newComment,
    ])

    content.value = ''

    add({
      type: 'success',
      title: 'Comment created',
      description: 'Your comment has been created successfully.',
    })
  },
  onError: () => {
    add({
      type: 'error',
      title: 'Error',
      description: 'An error occurred while creating your comment.',
    })
  },
  onSettled: () => {
    queryCache.invalidateQueries({ key: ['comments', window.postId] })
  },
})
function submit() {
  storeComment(content.value)
}
</script>

<template>
  <ConfigProvider>
    <div class="mt-16">
      <section class="mx-auto max-w-screen-md">
        <h2 class="text-center text-lg font-bold">
          Do you like this post?
        </h2>

        <div class="mt-4 flex justify-center">
          <span v-if="emojiState.status === 'pending'">Loading...</span>
          <template v-else-if="emojiState.data">
            <Emoji v-for="emoji in emojiState.data" :key="emoji.id" :emoji="emoji" />
          </template>
        </div>
      </section>

      <section class="mx-auto mt-16 max-w-screen-md">
        <h2 class="text-center text-lg font-bold">
          Comments
        </h2>

        <div class="mt-4">
          <Comment v-for="comment in commentsState.data" :key="comment.id" :comment="comment" @delete="onDelete(comment)" />
        </div>

        <form @submit.prevent="submit">
          <div class="mt-4">
            <textarea v-model="content" class="w-full rounded border border-gray-300 p-2" rows="4" placeholder="Leave a comment" />
          </div>

          <div class="mt-4 flex justify-end">
            <button type="submit" class="rounded bg-blue-500 px-4 py-2 text-white disabled:bg-blue-300" :disabled="isCreatingComment">
              <span v-if="isCreatingComment">Loading...</span>
              <span v-else>Submit</span>
            </button>
          </div>
        </form>
      </section>

      <AuthenticationDialog />

      <Toaster />
    </div>
  </ConfigProvider>
</template>
