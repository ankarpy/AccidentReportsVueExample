export default {
    modify (user, model) {
        return user.id === model.user_id;
    },

    deleteReport (user, report) {
        return user.id === report.user_id;
    }
}
