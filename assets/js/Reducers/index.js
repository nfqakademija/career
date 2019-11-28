import { combineReducers } from 'redux';
import { profilesList } from './profilesList';
import { selectedProfile } from './selectedProfile';

export const allReducer = combineReducers({
    profilesList,
    selectedProfile
})