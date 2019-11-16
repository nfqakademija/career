import { combineReducers } from 'redux';
import { profileId } from './profileId';
import { profilesList } from './profilesList';

export const allReducer = combineReducers({
    profileId,
    profilesList
})