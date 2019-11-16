const initialState = {
  profiles: []
};

export const profilesList = (state = initialState, action) => {
  switch (action.type) {
    case "setProfilesList":
      return {
        ...state,
        profiles: action.profiles
      };
    default:
      return state;
  }
};
