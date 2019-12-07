import { combineReducers } from 'redux';
import { profilesList } from './profilesList';
import { selectedProfile } from './selectedProfile';
import { user } from './User';
import { trackUserChanges } from './trackUserChanges';
//rootReducer

const appReducer = combineReducers({
    profilesList,
    selectedProfile,
    user,
    trackUserChanges
})

export const allReducer = (state, action) =>{
    if(action.type === "RESET_APP"){
        state = undefined;
    }

    return appReducer(state, action);
}