import { combineReducers } from 'redux';
import { profilesList } from './profilesList';
import { selectedProfile } from './selectedProfile';
import { user } from './User';

export const allReducer = combineReducers({
    profilesList,
    selectedProfile,
    user
})