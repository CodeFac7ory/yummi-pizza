import React from 'react';
import Adapter from 'enzyme-adapter-react-16';
import renderer from 'react-test-renderer';
import Enzyme, { configure, shallow, mount } from 'enzyme';
import Main from './../components/Main';

configure({ adapter: new Adapter() });

const main = shallow(<Main />);

it('renders correctly', () => {
	expect(main).toMatchSnapshot();
});
