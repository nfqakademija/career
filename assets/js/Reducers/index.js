import { combineReducers } from 'redux';
import { profilesList } from './profilesList';
import { selectedProfile } from './selectedProfile';
import { user } from './User';
import { trackUserChanges } from './trackUserChanges';

export const allReducer = combineReducers({
    profilesList,
    selectedProfile,
    user,
    trackUserChanges
})