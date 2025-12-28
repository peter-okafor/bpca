import { createSlice, PayloadAction } from '@reduxjs/toolkit'
import { PestInterface } from '@frontend/data/ProviderInterface'
import { RootState } from '@frontend/redux/store'
// import type { RootState } from '../../app/store'

// Define a type for the slice state

// Define the initial state using that type
type homeType = {
    pests: PestInterface[],
    selectedPest: string,
    selectedPostcode: string,
    searchOpen: boolean
};

const initialState: homeType = {
    pests: [],
    selectedPest: '',
    selectedPostcode: '',
    searchOpen: true
};

export const homeSlice = createSlice({
  name: 'pest',
  // `createSlice` will infer the state type from the `initialState` argument
  initialState,
  reducers: {
    // Use the PayloadAction type to declare the contents of `action.payload`
    
    savePestList: (state, action: PayloadAction<PestInterface[]>) => {
      state.pests = action.payload;
    },

    saveSelectedPest: (state, action: PayloadAction<string>) => {
        state.selectedPest = action.payload
    },

    saveSelectedPostcode: (state, action: PayloadAction<string>) => {
        state.selectedPostcode = action.payload
    },

    saveSearchOpen: (state, action: PayloadAction<boolean>) => {
        state.searchOpen = action.payload
    },
  },
})

export const { savePestList, saveSelectedPest, saveSelectedPostcode, saveSearchOpen } = homeSlice.actions

// Other code such as selectors can use the imported `RootState` type
export const selectPestList = (state: RootState) => state.search.pests
export const selectSelectedPest = (state: RootState) => state.search.selectedPest
export const selectSelectedPostcode = (state: RootState) => state.search.selectedPostcode
export const selectSearchOpen = (state: RootState) => state.search.searchOpen

export default homeSlice.reducer