export function useReactions() {
  return useQuery({
    key: ['reactions', window.postId],
    query: () => getUserPostReactions(window.postId),
  })
}
