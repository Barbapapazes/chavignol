export function useComments() {
  return useQuery({
    key: ['comments', window.postId],
    query: () => getComments(window.postId).then(response => response.data),
  })
}
