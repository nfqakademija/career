const initialState = {
  profileId: false
};

export const profileId = (state = initialState, action) => {
  switch (action.type) {
    case "setSelectedProfileButton":
      return {
        ...state,
        profileId: action.profileId
      };
    default:
      return state;
  }
};
