limit = 5
axios.get('/notifications', { params: { limit } })
    .then(({ data: { total, notifications } }) => {
        this.total = total
        this.notifications = notifications.map(({ id, data, created }) => {
            return {
                id: id,
                title: data.title,
                body: data.body,
                created: created,
                action_url: data.action_url
            }
        })
    });
