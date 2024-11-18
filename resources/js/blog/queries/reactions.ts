export function useReactions() {
  return useQuery({
    key: ['reactions', window.postId],
    query: () => getUserReactions(window.postId).then(response => response.data),
  })
}
