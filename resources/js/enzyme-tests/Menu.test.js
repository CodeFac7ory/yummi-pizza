import React from 'react';
import { act } from 'react-dom/test-utils';
import Adapter from 'enzyme-adapter-react-16';
import renderer from 'react-test-renderer';
import Enzyme, { configure, shallow, mount } from 'enzyme';
import Menu from './../components/Menu';
import axios from 'axios';
import MockAdapter from 'axios-mock-adapter';

import "babel-polyfill";

var mock = new MockAdapter(axios);

configure({ adapter: new Adapter() });

//this is set in Laravel
global.Auth = {
	user: {},
	token: ""
};

it('renders correctly', async () => {

  mock.onGet("/yummi-pizza/public/api/pizzas").reply(200, {
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
	});

  mock.onGet("/yummi-pizza/public/api/cart").reply(200, {
  });

	await act(async () => {

	  const menu = mount(<Menu />);

	  setTimeout(() => {
	  	menu.update();
			const button = menu.find('button');
			expect(button).toHaveLength(2)
	  });
	});
});