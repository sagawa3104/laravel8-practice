import React from 'react';
import ReactDOM from 'react-dom';

const App = () => {
    return(
        <div className="">
            <div className="form__group">
                <label className="form-label" htmlFor="email">メールアドレス:</label>
                <input className="form-input" type="text" id="email" name="email" />
            </div>
            <div className="form__group">
                <label className="form-label" htmlFor="password">パスワード:</label>
                <input className="form-input" type="password" id="password" name="password" />
            </div>
            <button className="button" type="submit">ログイン</button>
        </div>
    )
}

if (document.getElementById('app')) {
    ReactDOM.render(<App />, document.getElementById('app'));
}
