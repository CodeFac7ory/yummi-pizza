import React from 'react';
import { rest } from 'msw';
import { setupServer } from 'msw/node';
import '@testing-library/jest-dom';
import { render, fireEvent, screen, waitFor } from '@testing-library/react';
import { act } from 'react-dom/test-utils';
import "babel-polyfill";
import Cart from '../components/Cart';

const server = setupServer(
  rest.get('/yummi-pizza/public/api/cart', (req, res, ctx) => {
    return res(
			ctx.status(200),
    	ctx.json([
	    {
				"id":29,
				"user_id":1,
				"token":"cNLZ0U818nsQCQux8MkptYjZf9XqZbSFvTt5vQS0",
				"total_price":1898,
				"name":null,
				"street":null,
				"postal_code":null,
				"city":null,
				"country":null,
				"status":"pending",
				"created_at":"2020-10-07 13:20:00",
				"updated_at":"2020-10-07 13:20:00",
				"items": [
					// {"id":30,"order_id":29,"pizza_id":1,"quantity":1,"price":799,"created_at":"2020-10-07 13:20:00","updated_at":"2020-10-07 13:20:00","name":"Funghi Pizza","picture":"https://i0.wp.com/www.sugarlovespices.com/wp-content/uploads/2019/06/Pizza-Funghi-e-Salsiccia-Mushroom-and-Sausage-Pizza-feat.jpg?w=683&ssl=1"},
					// {"id":31,"order_id":29,"pizza_id":2,"quantity":1,"price":899,"created_at":"2020-10-07 13:20:00","updated_at":"2020-10-07 13:20:00","name":"Quattro Formaggi","picture":"https://media-cdn.tripadvisor.com/media/photo-s/0f/c5/06/a6/pizza-quattro-formaggi.jpg"}
				]
	    }
    ]))
  }),
);

global.Auth = {
	user: {
		id: 1,
		name: 'bosko',
		street: '221b Baker St',
		postal_code: 'NW1 6XE',
		city: 'London',
		country: 'United Kingdom'
	},
	token: ""
};


beforeAll(() => server.listen())
afterEach(() => server.resetHandlers())
afterAll(() => server.close())

test('Renders empty shoping cart correctly', async () => {
	render(<Cart />);

	const loadingLabel = await waitFor(() => screen.getAllByText('Loading'));
	expect(loadingLabel).toHaveLength(1);
	const cartEmptyLabel = await waitFor(() => screen.getAllByText('The shopping cart is empty!'));
	expect(cartEmptyLabel).toHaveLength(1);
});