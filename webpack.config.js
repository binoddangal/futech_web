const path = require('path');

module.exports = {

    "resolve": {
        "symlinks": false,
        "extensions": ['.vue', '.js', '.jsx'],
        "alias": {
            "@": path.resolve(__dirname, 'resources', 'js')
        }
    }
}
