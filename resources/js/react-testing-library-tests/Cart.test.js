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
    	ctx.json([{
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
				{"id":30,"order_id":29,"pizza_id":1,"quantity":1,"price":799,"created_at":"2020-10-07 13:20:00","updated_at":"2020-10-07 13:20:00","name":"Funghi Pizza","picture":"https://i0.wp.com/www.sugarlovespices.com/wp-content/uploads/2019/06/Pizza-Funghi-e-Salsiccia-Mushroom-and-Sausage-Pizza-feat.jpg?w=683&ssl=1"},
				{"id":31,"order_id":29,"pizza_id":2,"quantity":1,"price":899,"created_at":"2020-10-07 13:20:00","updated_at":"2020-10-07 13:20:00","name":"Quattro Formaggi","picture":"https://media-cdn.tripadvisor.com/media/photo-s/0f/c5/06/a6/pizza-quattro-formaggi.jpg"}
			]
    }]))
  }),

  rest.delete('/yummi-pizza/public/api/order_items/30', (req, res, ctx) => {
    return res(
			ctx.status(200),
    	ctx.json([{
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
				{"id":31,"order_id":29,"pizza_id":2,"quantity":1,"price":899,"created_at":"2020-10-07 13:20:00","updated_at":"2020-10-07 13:20:00","name":"Quattro Formaggi","picture":"https://media-cdn.tripadvisor.com/media/photo-s/0f/c5/06/a6/pizza-quattro-formaggi.jpg"}
			]
    }]))
  }),

  rest.patch('/yummi-pizza/public/api/orders/29/complete', (req, res, ctx) => {
  	return res(ctx.json(200));
  })
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



test('Loads shoping cart correctly and deletes first item', async () => {
	render(<Cart />);

	const removeFromCartButtons = await waitFor(() => screen.getAllByText('Remove from cart'));
	expect(removeFromCartButtons).toHaveLength(2);

	await act(async () => {
		const res = await fireEvent.click(removeFromCartButtons[0]);
	});

	const removeFromCartButtons1 = await waitFor(() => screen.getAllByText('Remove from cart'));
	expect(removeFromCartButtons1).toHaveLength(2);
});


test('Loads shoping cart correctly, deletes first item and completes order when user is logged in', async () => {
	render(<Cart />);

	const removeFromCartButtons = await waitFor(() => screen.getAllByText('Remove from cart'));
	expect(removeFromCartButtons).toHaveLength(2);

	const orderButton = await waitFor(() => screen.getByRole('order'));

	await act(async () => {
		const res = await fireEvent.click(orderButton);
	});

	const orderComplete = await waitFor(() => screen.getAllByText(/^The order is complete/));
	expect(orderComplete).toHaveLength(1);
});

test('Loads shoping cart correctly and loads the address form if the user is not logged in', async () => {

	global.Auth = {
		user: null
	};

	render(<Cart />);

	const removeFromCartButtons = await waitFor(() => screen.getAllByText('Remove from cart'));
	expect(removeFromCartButtons).toHaveLength(2);

	const orderButton = await waitFor(() => screen.getByRole('order'));

	await act(async () => {
		const res = await fireEvent.click(orderButton);
	});

	const addressForm = await waitFor(() => screen.getByText('Address'));
});

