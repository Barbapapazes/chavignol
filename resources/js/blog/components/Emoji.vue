<script lang="ts" setup>
import type { Reaction, ReactionCount } from '@/blog/types/reaction'

const props = defineProps<{
  emoji: ReactionCount
}>()

const { state: reactionsState } = useReactions()

const isReacted = computed(() => {
  if (!window.isLoggedIn) {
    return false
  }

  if (reactionsState.value.status === 'success') {
    return reactionsState.value.data.some(reaction => reaction.emoji.id === props.emoji.id)
  }

  return false
})

const { add } = useToast()

const queryCache = useQueryCache()
const {
  mutate: react,

} = useMutation({
  mutation: ({ postId, emojiId }: { postId: number, emojiId: number }) => storeReaction(postId, emojiId),
  onMutate: () => {
    // Update the emoji count
    const oldEmoji = queryCache.getQueryData<ReactionCount[]>(['emoji', window.postId]) || []

    const emojiIndex = oldEmoji.findIndex(emoji => emoji.id === props.emoji.id)

    let newEmoji = oldEmoji
    if (emojiIndex !== -1) {
      newEmoji = oldEmoji.toSpliced(emojiIndex, 1, {
        ...props.emoji,
        count: props.emoji.count + 1,
      })

      queryCache.setQueryData(['emoji', window.postId], newEmoji)
      queryCache.cancelQueries({ key: ['emoji', window.postId], exact: true })
    }

    // Add the reaction to the list
    const oldReactions = queryCache.getQueryData<Reaction[]>(['reactions', window.postId]) || []

    let newReactions = oldReactions

    newReactions = [
      ...oldReactions,
      {
        id: 0,
        emoji: props.emoji,
      },

    ]

    queryCache.setQueryData(['reactions', window.postId], newReactions)
    queryCache.cancelQueries({ key: ['reactions', window.postId], exact: true })

    return { oldEmoji, newEmoji, oldReactions, newReactions }
  },
  onSuccess: (reaction) => {
    const reactions = queryCache.getQueryData<Reaction[]>(['reactions', window.postId]) || []
    const reactionIndex = reactions.findIndex(reaction => reaction.emoji.id === props.emoji.id)
    if (reactionIndex !== -1) {
      queryCache.setQueryData(['reactions', window.postId], reactions.toSpliced(reactionIndex, 1, reaction.data))
    }

    add({
      title: 'Success',
      description: 'Your reaction has been saved.',
      type: 'success',
    })
  },
  onError: (_, __, { oldEmoji, newEmoji, oldReactions, newReactions }) => {
    // Rollback the changes
    if (newEmoji !== null && newEmoji === queryCache.getQueryData<ReactionCount[]>(['emoji', window.postId])) {
      queryCache.setQueryData(['emoji', window.postId], oldEmoji)
    }

    if (newReactions !== null && newReactions === queryCache.getQueryData<Reaction[]>(['reactions', window.postId])) {
      queryCache.setQueryData(['reactions', window.postId], oldReactions)
    }

    add({
      title: 'Error',
      description: 'An error occurred while saving your reaction.',
      type: 'error',
    })
  },
  onSettled: () => {
    queryCache.invalidateQueries({ key: ['emoji', window.postId] })
    queryCache.invalidateQueries({ key: ['reactions', window.postId] })
  },
})

const {
  mutate: unreact,
} = useMutation({
  mutation: ({ postId, reactionId }: { postId: number, reactionId: number }) => deleteReaction(postId, reactionId),
  onMutate: () => {
    // Update the emoji count
    const oldEmoji = queryCache.getQueryData<ReactionCount[]>(['emoji', window.postId]) || []

    const emojiIndex = oldEmoji.findIndex(emoji => emoji.id === props.emoji.id)

    let newEmoji = oldEmoji
    if (emojiIndex !== -1) {
      newEmoji = oldEmoji.toSpliced(emojiIndex, 1, {
        ...props.emoji,
        count: props.emoji.count - 1,
      })

      queryCache.setQueryData(['emoji', window.postId], newEmoji)
      queryCache.cancelQueries({ key: ['emoji', window.postId], exact: true })
    }

    // Remove the reaction from the list
    const oldReactions = queryCache.getQueryData<Reaction[]>(['reactions', window.postId]) || []

    const reactionIndex = oldReactions.findIndex(reaction => reaction.emoji.id === props.emoji.id)

    let newReactions = oldReactions
    if (reactionIndex !== -1) {
      newReactions = oldReactions.toSpliced(reactionIndex, 1)

      queryCache.setQueryData(['reactions', window.postId], newReactions)
      queryCache.cancelQueries({ key: ['reactions', window.postId], exact: true })
    }

    return { oldEmoji, newEmoji, oldReactions, newReactions }
  },
  onSuccess: () => {
    add({
      title: 'Success',
      description: 'Your reaction has been removed.',
      type: 'success',
    })
  },
  onError: (_, __, { oldEmoji, newEmoji, oldReactions, newReactions }) => {
    // Rollback the changes
    if (newEmoji !== null && newEmoji === queryCache.getQueryData<ReactionCount[]>(['emoji', window.postId])) {
      queryCache.setQueryData(['emoji', window.postId], oldEmoji)
    }

    if (newReactions !== null && newReactions === queryCache.getQueryData<Reaction[]>(['reactions', window.postId])) {
      queryCache.setQueryData(['reactions', window.postId], oldReactions)
    }

    add({
      title: 'Error',
      description: 'An error occurred while removing your reaction.',
      type: 'error',
    })
  },
  onSettled: () => {
    queryCache.invalidateQueries({ key: ['emoji', window.postId] })
    queryCache.invalidateQueries({ key: ['reactions', window.postId] })
  },
})

const { open } = useAuthenticationDialog()
function onClick() {
  if (!window.isLoggedIn) {
    open()
    return
  }

  if (isReacted.value) {
    const reaction = reactionsState.value.data?.find(reaction => reaction.emoji.id === props.emoji.id)

    unreact({
      postId: window.postId,
      reactionId: reaction!.id,
    })
  }
  else {
    react({
      postId: window.postId,
      emojiId: props.emoji.id,
    })
  }
}
</script>

<template>
  <button type="button" class="flex flex-col items-center justify-center gap-1 p-4 text-5xl grayscale-[80%] transition-[filter] duration-150 ease-in hover:grayscale-0 data-[reacted=true]:drop-shadow-md data-[reacted=true]:grayscale-0" :data-reacted="isReacted" @click="onClick">
    <span>{{ emoji.emoji }}</span>
    <span class="text-sm text-neutral-400">{{ emoji.count }}</span>
  </button>
</template>
