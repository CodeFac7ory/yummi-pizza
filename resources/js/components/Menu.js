import React, { useState, useEffect } from 'react';
import ReactDOM from 'react-dom';
import axios from 'axios';

function Menu(props) {

	const [pizzas, setPizzas] = useState([]);
	const [order, setOrder] = useState(null);
	const [items, setItems] = useState([]);
	const [quantities, setQuantities] = useState([]);

	useEffect(() => {
		axios.get('/yummi-pizza/public/api/pizzas', {
	    _token: window.Auth.token
	  })
	  .then(function (response) {
	    setPizzas(response.data.data);

	    const temp = [];
	    for (let i = 0; i < response.data.data.length ; ++i) {
	    	temp.push(1);
	    }

			setQuantities(temp);
	  })
	  .catch(function (error) {
	    console.log('[[pizzas error]]');
	    console.log(error);
	  })

	  let params = {};
		if (window.Auth.user) {
			params = { user_id: window.Auth.user.id }
		}

		axios.get('/yummi-pizza/public/api/cart', {
			params: params,
		  headers: {
		    'X-CSRFToken': `${window.Auth.token}`
		  }
	  })
	  .then(function (response) {
	  	if (response.data[0]) {
		  	setItems(response.data[0].items);
		    setOrder(response.data[0]);
	  	}
	  })
	  .catch(function (error) {
	  	console.log('[[[[cart error]]]]');
	  	console.log(error);
	  })

  }, []);

	useEffect(() => {

	  if (items.length > 0) {

		  let totalPrice = 0;
		  items.forEach((item) => {
				totalPrice += item.price;
		  });

		  totalPrice += props.delieveryCosts;

			if (!order) {
				setOrder({
					user_id: window.Auth.user ? window.Auth.user.id : null,
					token: window.Auth.token,
					items: items,
					total_price: totalPrice,
					status: 'pending',
				});
			}
			else {
				setOrder(prevObj => ({...prevObj, items: items, total_price: totalPrice}));
			}
	  }
	}, [items]);

	useEffect(() => {
		console.log('[[[menu.js order]]]');
		console.log(order);

		if (order && order.id) {

			axios.put('/yummi-pizza/public/api/orders/' + order.id, order)
		  .then(function (response) {
		    console.log('[[put order response]]');
		    console.log(response);

		    //enable buttons again after item is saved to db
		    document.querySelectorAll('.btn-success').forEach(elem => {
				  elem.disabled = false;
				});

		    // setOrder(null);
		  })
		  .catch(function (error) {
		    console.log('[[put order error]]');
		    console.log(error);
		  })

		}
		else if (order){

			axios.post('/yummi-pizza/public/api/orders', order)
		  .then(function (response) {
		    console.log('[[response]]');
		    console.log(response);

		    //enable buttons again after item is saved to db
		    document.querySelectorAll('.btn-success').forEach(elem => {
				  elem.disabled = false;
				});

		    // setOrder(null);
		  })
		  .catch(function (error) {
		    console.log('[[error]]');
		    console.log(error);
		  })
		}
	}, [order]);

	const addToCart = (e, item, quantity) => {
		//disable button until we get response
		e.target.disabled = true;

		console.log(item);
		console.log(quantity);

		const newItem = {
			pizza_id: item.id,
			quantity: quantity,
			price: quantity * item.price,
		};

		console.log('[[[newItem]]]');
		console.log(newItem);

		setItems(prevArray  => [...prevArray, newItem]);
  };

  return (
	  <div>
	  	<br />
	  	<br />
		  {pizzas.map((value, index) => {
		  	return (<div key={index} className="row mx-md-n5 mb-2">
		  		<div className="col-xs-12 col-md-3 my-auto">
		  			<img src={value.picture} style={{
			  			display: 'block',
						  // maxWidth: 230,
						  // maxHeight: 150,
						  width: '100%',
						  height: 'auto',
	  				}}/>
	  			</div>
		  		<div className="col-xs-push-0 col-xs-6 col-md-5 col-lg-6 my-auto">
		  			<h4>{value.name}</h4>
		  			<p className="text-justify">{value.description}</p>
		  		</div>
		  		<div className="col-xs-2 col-md-2 col-lg-1 my-auto">
		  			<input type="number"
		  				name={ "quantity_" +  value.id }
		  				min="1"
		  				step="1"
		  				className="form-control"
 							value={quantities && quantities[index] ? quantities[index] : ''}
 							onChange={(e) => {
								let temp = [...quantities];
								temp[index] = parseInt(e.target.value);
								setQuantities(temp);
 							}}
		  			/>
		  		</div>
		  		<div className="col-xs-2 col-md-1 my-auto pt-2">
		  			<h5>
		  				{props.currencySymbol} { (Math.round(value.price * (quantities && quantities[index] ? quantities[index] : 0)
		  					* props.currencyExchangeRate) / 100).toFixed(2)}
		  			</h5>
		  		</div>
		  		<div className="col-xs-2 col-md-1 my-auto">
		  			<button type="button" className="add-to-cart btn btn-success float-right btn-sm"
		  				onClick={(e) => addToCart(e, value, quantities[index])}
		  			>
		  				Add to cart
		  			</button>
		  		</div>
		  	</div>)
		  })}
	  </div>
  );
}

export default Menu;