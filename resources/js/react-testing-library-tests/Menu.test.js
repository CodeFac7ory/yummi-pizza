import React from 'react';
import { rest } from 'msw';
import { setupServer } from 'msw/node';
import '@testing-library/jest-dom';
import { render, fireEvent, screen, waitFor } from '@testing-library/react';
import Menu from '../components/Menu';
import "babel-polyfill";

const server = setupServer(
  rest.get('/yummi-pizza/public/api/pizzas', (req, res, ctx) => {
    return res(ctx.json({
    	data: [
    		{
    			id: 1,
    			name: "Funghi Pizza",
    			description: "Lorem Ipsum",
    			picture: "https://i0.wp.com/www.sugarlovespices.com/wp-conte…a-Mushroom-and-Sausage-Pizza-feat.jpg?w=683&ssl=1",
    			price: 799
    		},
    		{
    			id: 2,
    			name: "Funghi Pizza",
    			description: "Lorem Ipsum",
    			picture: "https://i0.wp.com/www.sugarlovespices.com/wp-conte…a-Mushroom-and-Sausage-Pizza-feat.jpg?w=683&ssl=1",
    			price: 799
    		}
    	]
    }))
  })
)

global.Auth = {
	user: {
	},
	token: ""
};

beforeAll(() => server.listen())
afterEach(() => server.resetHandlers())
afterAll(() => server.close())

test('Loads menu items correctly and adds to shopping cart', async () => {
	render(<Menu />);
	const button = await waitFor(() => screen.getAllByText('Add to cart'));
	expect(button).toHaveLength(2);
});


