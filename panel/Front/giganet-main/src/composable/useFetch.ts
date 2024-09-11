export default function useFetch(
  ...args: Parameters<typeof $fetch>
): Promise<any> {
  const config = useRuntimeConfig();
  const cookies = useCookie("GiganetUSERToken", {
    maxAge: 60 * 60 * 24 * 30, // 1 month
  });

  return $fetch(args[0], {
    baseURL: config.apiOrigin || "https://api.gigamarket.app",
    ...args[1],
    headers: {
      Authorization: cookies.value || "",
      ...args[1]?.headers,
    },
  });
}