import React from 'react';
import ReactDOM from 'react-dom';
import { Route, BrowserRouter as Router, Switch, Link } from 'react-router-dom';

import Cart from './Cart';
import Menu from './Menu';

function Main() {

	let active;

	if (window.location.href.includes('cart')) {
		active = 'cart';
	}
	else {
		active = 'home';
	}

	const [auth, setAuth] = React.useState(null);

	React.useEffect(() => {
		if (window.Auth) {
    	setAuth(window.Auth);
		}
  }, []);

	function logout(e) {
    e.preventDefault();

		axios.post('/yummi-pizza/public/logout', {
	    _token: window.Auth.token
	  })
	  .then(function (response) {
	    console.log('[[response]]');
	    console.log(response);

	    setAuth(null);
	  })
	  .catch(function (error) {
	    console.log('[[error]]');
	    console.log(error);
	  })
	  .then(function () {

	  });
  }

  return (
  	<div>
			<Router>
				<nav className="navbar navbar-expand-lg navbar-light bg-light">
				  <button className="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
				    <span className="navbar-toggler-icon"></span>
				  </button>
				  <div className="collapse navbar-collapse" id="navbarSupportedContent">
				    <ul className="navbar-nav mr-auto">
				      <Link className="nav-link" to="/yummi-pizza/public/">Home</Link>
				      {!(auth && auth.user) && (
				      <li className="nav-item">
				        <a className="nav-link" href="/yummi-pizza/public/login">Login</a>
				      </li>
				      )}
				      <Link className="nav-link" to="/yummi-pizza/public/cart">Shopping Cart</Link>
				      {auth && auth.user && (
		      			<li className="nav-item dropdown">
					        <a className="nav-link dropdown-toggle"
					        	href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true"
					        	aria-expanded="false"
					        >
					          {auth.user.name}
					        </a>
		        			<div className="dropdown-menu" aria-labelledby="navbarDropdown">
					          <a className="dropdown-item" href="logout" onClick={logout}>Logout</a>
					        </div>
					      </li>
				      )}
				    </ul>
{/*				    <ul className="navbar-nav mr-auto">
				      <Link className="nav-link" to="/">Home</Link>
				      {!(auth && auth.user) && (
				      <li className="nav-item">
				        <a className="nav-link" href="/login">Login</a>
				      </li>
				      )}
				      <Link className="nav-link" to="/cart">Shopping Cart</Link>
				      {auth && auth.user && (
		      			<li className="nav-item dropdown">
					        <a className="nav-link dropdown-toggle"
					        	href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true"
					        	aria-expanded="false"
					        >
					          {auth.user.name}
					        </a>
		        			<div className="dropdown-menu" aria-labelledby="navbarDropdown">
					          <a className="dropdown-item" href="logout" onClick={logout}>Logout</a>
					        </div>
					      </li>
				      )}
				    </ul>*/}
				  </div>
				</nav>
				<React.Fragment>
					<main>
						<Switch>
				      <Route path="/yummi-pizza/public/" component={Menu} exact />
				      <Route path="/yummi-pizza/public/cart" component={Cart} />
{/*				      <Route path="/" component={Menu} exact />
				      <Route path="/cart" component={Cart} />*/}
				    </Switch>
	        </main>
        </React.Fragment>
      </Router>
  	</div>
  );
}

export default Main;

if (document.getElementById('main')) {
  ReactDOM.render(<Main />, document.getElementById('main'));
}