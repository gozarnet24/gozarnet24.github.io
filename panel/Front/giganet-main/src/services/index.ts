import useFetch from "~/composable/useFetch";

export function getUserData(token: string): Promise<any> {
    return useFetch("/api/me", {
        headers: {
            Authorization: token,
        },
    });
}

export function loginUser({username, password}): Promise<any> {
    const params = {
        username,
        password
    };
    return useFetch("/api/login", {
        method: "POST",
        body: params,
    });
}

export function checkNotification(id: number): Promise<any> {
    return useFetch("/api/check-notification/" + id);
}

export function changePassword(password: string): Promise<any> {
    return useFetch("api/reset-password", {
        method: "POST",
        body: {
            password,
        }
    });
}
