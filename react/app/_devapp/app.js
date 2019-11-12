import React, { Component, Fragment } from 'react';
import { render } from 'react-dom';
import { asyncComponent } from 'react-async-component';

/** We are importing our index.php my app Vairaible */
import appData from 'appData';

/* globals __webpack_public_path__ */
__webpack_public_path__ = `${window.STATIC_URL}/app/assets/bundle/`;

class MadrapurScreens extends Component {
    render() {

        const { user : { name, email }, logged } = appData;

        return (
            <Fragment>
                <div className="dashboard">
                {logged &&
                    <h2 className="status">Logged In</h2>
                }
                <h1 className="name"> {name}</h1>
                <p className="email">{email}</p>

                <p>API host variable {__API_HOST__}</p>
            </div>
        </Fragment>
        )
    }
}

render(<MadrapurScreens/>, document.getElementById('madrapurScreens'));
