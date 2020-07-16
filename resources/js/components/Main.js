import React from 'react';
import ReactDOM from 'react-dom';

function Main() {
  return (
		<div className="container">Main</div>
  );
}

export default Main;

console.log('main');
console.log(document.getElementById('main'));

if (document.getElementById('main')) {
  ReactDOM.render(<Main />, document.getElementById('main'));
}