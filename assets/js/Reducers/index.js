import { combineReducers } from 'redux';
import { profilesList } from './profilesList';
import { selectedProfile } from './selectedProfile';
import { email } from './User';

export const allReducer = combineReducers({
    profilesList,
    selectedProfile,
    email
})