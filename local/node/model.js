'user strict';
var sql = require(__dirname + '/db.js');
//User object constructor
var User = function (user) {
    this.user = user.user;
    this.status = user.status;
    this.created_at = new Date();
};
User.createUser = function (newUser, result) {
    sql.query("INSERT INTO users set ?", newUser, function (err, res) {

        if (err) {
            console.log("error: ", err);
            result(err, null);
        }
        else {
            console.log(res.insertId);
            result(null, res.insertId);
        }
    });
};
User.getUserById = function (userId, result) {
    // sql.query("Select * from users where id = ? AND last_token = ?", [userId, last_token], function (err, res) {
    sql.query("Select * from users where id = ?", [userId], function (err, res) {
        if (err) {
            console.log("error: ", err);
            result(err, null);
        }
        else {
            result(null, res);

        }
    });
};
User.getAllUser = function (result) {
    sql.query("Select * from users", function (err, res) {

        if (err) {
            console.log("error: ", err);
            result(null, err);
        }
        else {
            console.log('users : ', res);

            result(null, res);
        }
    });
};
User.updateById = function (id, last_status, last_connected_at, result) {
    sql.query("UPDATE users SET last_status = ?, last_connected_at = ? WHERE id = ?", [last_status, last_connected_at, id], function (err, res) {
        if (err) {
            console.log("error: ", err);
            result(null, err);
        }
        else {
            result(null, res);
        }
    });
};
User.remove = function (id, result) {
    sql.query("DELETE FROM users WHERE id = ?", [id], function (err, res) {

        if (err) {
            console.log("error: ", err);
            result(null, err);
        }
        else {

            result(null, res);
        }
    });
};

module.exports = User;
